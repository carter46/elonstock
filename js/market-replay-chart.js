/**
 * Bloomberg — delayed market replay charts (TradingView Lightweight Charts).
 */
(function (global) {
    'use strict';

    var LW_CDN = 'https://unpkg.com/lightweight-charts@4.2.0/dist/lightweight-charts.standalone.production.js';
    var lwLoadPromise = null;

    function loadLightweightCharts() {
        if (global.LightweightCharts) {
            return Promise.resolve(global.LightweightCharts);
        }
        if (lwLoadPromise) {
            return lwLoadPromise;
        }
        lwLoadPromise = new Promise(function (resolve, reject) {
            var s = document.createElement('script');
            s.src = LW_CDN;
            s.async = true;
            s.onload = function () {
                resolve(global.LightweightCharts);
            };
            s.onerror = function () {
                reject(new Error('Failed to load Lightweight Charts'));
            };
            document.head.appendChild(s);
        });
        return lwLoadPromise;
    }

    function getReplaySpeed(wrap) {
        if (wrap) {
            var fromAttr = parseFloat(wrap.getAttribute('data-replay-speed') || '');
            if (!isNaN(fromAttr) && fromAttr > 0) {
                return Math.min(10, fromAttr);
            }
        }
        var params = new URLSearchParams(global.location.search);
        var fromUrl = parseFloat(params.get('replay_speed') || '');
        if (!isNaN(fromUrl) && fromUrl > 0) {
            return Math.min(10, fromUrl);
        }
        return 1;
    }

    function formatPrice(price) {
        if (price == null || isNaN(price)) return '--';
        if (price >= 1000) {
            return '$' + price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
        if (price >= 1) {
            return '$' + price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 4 });
        }
        if (price >= 0.01) {
            return '$' + price.toFixed(4);
        }
        return '$' + price.toFixed(6);
    }

    function formatForexPrice(price) {
        if (price == null || isNaN(price)) return '--';
        if (price >= 100) return price.toFixed(3);
        if (price >= 1) return price.toFixed(4);
        return price.toFixed(5);
    }

    function formatSyncTime(ts) {
        if (!ts) return '--';
        var d = new Date(ts * 1000);
        return d.toISOString().replace('T', ' ').slice(0, 19) + ' UTC';
    }

    function buildCandleMap(candles) {
        var map = {};
        (candles || []).forEach(function (c) {
            map[c.time] = c;
        });
        return map;
    }

    function interpolatePrice(candleMap, displayTime, interval) {
        var step = interval === '1s' ? 1 : 60;
        var t0 = Math.floor(displayTime / step) * step;
        var t1 = t0 + step;
        var c0 = candleMap[t0];
        var c1 = candleMap[t1];

        if (c0 && c1) {
            var frac = step === 1 ? 0 : (displayTime - t0) / step;
            return c0.close + (c1.close - c0.close) * frac;
        }
        if (c0) return c0.close;
        if (c1) return c1.close;

        var keys = Object.keys(candleMap).map(Number).sort(function (a, b) { return a - b; });
        for (var i = keys.length - 1; i >= 0; i--) {
            if (keys[i] <= displayTime) {
                return candleMap[keys[i]].close;
            }
        }
        if (keys.length) return candleMap[keys[0]].close;
        return null;
    }

    function flatCandle(time, price) {
        return { time: time, open: price, high: price, low: price, close: price };
    }

    function chartTheme(theme) {
        if (theme === 'light') {
            return {
                layout: { background: { color: '#F7F8FA' }, textColor: '#374151' },
                grid: { vertLines: { color: '#e5e7eb' }, horzLines: { color: '#e5e7eb' } },
                upColor: '#16a34a',
                downColor: '#dc2626',
                wickUpColor: '#16a34a',
                wickDownColor: '#dc2626',
            };
        }
        return {
            layout: { background: { color: '#1a1d24' }, textColor: '#9ca3af' },
            grid: { vertLines: { color: '#2a2f3a' }, horzLines: { color: '#2a2f3a' } },
            upColor: '#ffc35c',
            downColor: '#ef4444',
            wickUpColor: '#ffc35c',
            wickDownColor: '#ef4444',
        };
    }

    function MarketReplayChart(wrap) {
        this.wrap = wrap;
        this.slug = wrap.getAttribute('data-slug');
        this.height = parseInt(wrap.getAttribute('data-height') || '360', 10);
        this.theme = wrap.getAttribute('data-theme') || 'dark';
        this.showStatus = wrap.getAttribute('data-show-status') === '1';
        this.coingeckoId = wrap.getAttribute('data-coingecko-id') || '';
        this.replaySpeed = getReplaySpeed(wrap);
        this.chartEl = wrap.querySelector('.market-replay-chart');
        this.chart = null;
        this.series = null;
        this.candleMap = {};
        this.candles = [];
        this.serverTime = 0;
        this.displayTime = 0;
        this.delaySeconds = 900;
        this.interval = '1s';
        this.serverOffset = 0;
        this.lastKnownClose = null;
        this.tickTimer = null;
        this.pollTimer = null;
        this.initialized = false;
        this.paused = false;
        this.category = 'crypto';
        this.marketOpen = true;
        this.localDisplayTime = 0;
        this.tickStartWall = 0;
        this.tickStartDisplay = 0;
        this._lastGapFetchAt = 0;
        this._resyncInFlight = false;
        this._lastResyncAt = 0;
    }

    MarketReplayChart.prototype.destroy = function () {
        if (this.tickTimer) clearInterval(this.tickTimer);
        if (this.pollTimer) clearInterval(this.pollTimer);
        if (this.chart) {
            this.chart.remove();
            this.chart = null;
        }
    };

    MarketReplayChart.prototype.fetchPayload = function () {
        var self = this;
        return fetch('/api/market-replay.php?slug=' + encodeURIComponent(this.slug))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.error) throw new Error(data.error);
                return data;
            })
            .catch(function (err) {
                console.warn('Market replay fetch failed:', err.message);
                return null;
            });
    };

    MarketReplayChart.prototype.applyPayload = function (data, resync) {
        if (!data) return;

        this.serverTime = data.serverTime;
        this.delaySeconds = data.delaySeconds;
        this.displayTime = data.displayTime;
        this.interval = data.interval || '1s';
        this.candles = data.candles || [];
        this.candleMap = buildCandleMap(this.candles);
        this.category = data.category || 'crypto';
        this.marketOpen = data.marketOpen !== false;

        if (this.candles.length) {
            this.lastKnownClose = this.candles[this.candles.length - 1].close;
        }

        this.serverOffset = data.serverTime - Math.floor(Date.now() / 1000);
        this.localDisplayTime = data.displayTime;
        this.tickStartWall = Date.now();
        this.tickStartDisplay = data.displayTime;

        if (this.series) {
            var seriesData = this.candles.map(function (c) {
                return { time: c.time, open: c.open, high: c.high, low: c.low, close: c.close };
            });
            this.series.setData(seriesData);
        }

        this.updatePriceHeader(data);
        this.updateStatus(data);

        if (resync) {
            this.setStatusState(data.status && data.status.state ? data.status.state : 'synced');
        }
    };

    MarketReplayChart.prototype.updatePriceHeader = function (data) {
        var price = data.price && data.price.close != null
            ? data.price.close
            : interpolatePrice(this.candleMap, this.localDisplayTime, this.interval);

        var priceEl = this.wrap.querySelector('.market-replay-price');
        var changeEl = this.wrap.querySelector('.market-replay-change');
        var fmt = this.category === 'forex' ? formatForexPrice : formatPrice;

        if (priceEl && price != null) {
            priceEl.textContent = fmt(price);
        }

        if (changeEl && this.candles.length >= 2) {
            var first = this.candles[0].close;
            if (first > 0 && price != null) {
                var ch = ((price - first) / first) * 100;
                var sign = ch >= 0 ? '+' : '';
                changeEl.textContent = sign + ch.toFixed(2) + '%';
                changeEl.className = 'text-xs font-data-mono market-replay-change ' + (ch >= 0 ? 'text-success' : 'text-critical');
            }
        }

        var panel = this.wrap.closest('.market-detail-chart-wrap, .plan-market-chart-wrap');
        var header = panel ? panel.querySelector('.crypto-detail-header') : null;
        if (header) {
            var hp = header.querySelector('.crypto-price');
            var hc = header.querySelector('.crypto-change');
            if (hp && price != null) hp.textContent = fmt(price);
            if (hc && this.candles.length >= 2) {
                var f = this.candles[0].close;
                if (f > 0 && price != null) {
                    var pct = ((price - f) / f) * 100;
                    hc.textContent = (pct >= 0 ? '+' : '') + pct.toFixed(2) + '%';
                    hc.className = 'crypto-change font-data-mono text-sm ' + (pct >= 0 ? 'text-success' : 'text-critical');
                }
            }
        }

        if (this.coingeckoId && global.BloombitCryptoConfig) {
            var logo = global.BloombitCryptoConfig.getLogo
                ? global.BloombitCryptoConfig.getLogo(this.coingeckoId)
                : '';
            var img = this.wrap.querySelector('.market-replay-logo');
            if (img && logo) {
                img.src = logo;
                img.alt = data.name || this.slug;
            }
            var detailImg = header ? header.querySelector('.crypto-logo') : null;
            if (detailImg && logo) {
                detailImg.src = logo;
                detailImg.alt = data.name || this.slug;
            }
        }
    };

    MarketReplayChart.prototype.updateStatus = function (data) {
        if (!this.showStatus) return;
        var st = data.status || {};
        var syncEl = this.wrap.querySelector('.market-replay-status-sync');
        var delayEl = this.wrap.querySelector('.market-replay-status-delay');
        var healthEl = this.wrap.querySelector('.market-replay-status-health');
        var closedEl = this.wrap.querySelector('.market-replay-market-closed');

        if (syncEl) syncEl.textContent = formatSyncTime(st.lastServerSync);
        if (delayEl) delayEl.textContent = st.delayLabel || (this.delaySeconds / 60) + ' minutes';
        if (healthEl) healthEl.textContent = (st.bufferHealthPct != null ? st.bufferHealthPct : '--') + '%';
        if (closedEl) {
            closedEl.classList.toggle('hidden', this.marketOpen !== false);
        }
        this.setStatusState(st.state || (st.synced ? 'synced' : 'resyncing'));
    };

    MarketReplayChart.prototype.setStatusState = function (state) {
        if (!this.showStatus) return;
        var badge = this.wrap.querySelector('.market-replay-status-badge');
        var label = this.wrap.querySelector('.market-replay-status-label');
        if (!badge || !label) return;

        badge.classList.remove('text-success', 'text-amber-500', 'text-critical');
        if (state === 'degraded') {
            badge.classList.add('text-critical');
            label.textContent = 'Degraded';
        } else if (state === 'resyncing') {
            badge.classList.add('text-amber-500');
            label.textContent = 'Resyncing';
        } else {
            badge.classList.add('text-success');
            label.textContent = 'Synced';
        }
    };

    MarketReplayChart.prototype.onTick = function () {
        if (this.paused || !this.initialized) return;

        var elapsedSec = (Date.now() - this.tickStartWall) / 1000;
        this.localDisplayTime = this.tickStartDisplay + elapsedSec * this.replaySpeed;

        var serverNow = Math.floor(Date.now() / 1000) + this.serverOffset;
        var maxDisplay = serverNow - this.delaySeconds;
        if (this.localDisplayTime > maxDisplay) {
            this.localDisplayTime = maxDisplay;
        }

        var candle = this.candleMap[this.localDisplayTime];
        if (!candle && this.lastKnownClose != null) {
            candle = flatCandle(this.localDisplayTime, this.lastKnownClose);
            var nowMs = Date.now();
            if (nowMs - this._lastGapFetchAt > 15000) {
                this._lastGapFetchAt = nowMs;
                this.fetchPayload().then(function (d) {
                    if (d) this.applyPayload(d, true);
                }.bind(this));
            }
        } else if (candle) {
            this.lastKnownClose = candle.close;
        }

        var displayPrice;
        if (this.interval !== '1s') {
            displayPrice = interpolatePrice(this.candleMap, this.localDisplayTime, this.interval);
            if (displayPrice != null && this.series) {
                var tBucket = Math.floor(this.localDisplayTime / 60) * 60;
                var existing = this.candleMap[tBucket];
                if (existing) {
                    this.series.update({
                        time: tBucket,
                        open: existing.open,
                        high: Math.max(existing.high, displayPrice),
                        low: Math.min(existing.low, displayPrice),
                        close: displayPrice,
                    });
                }
            }
        } else if (candle && this.series) {
            this.series.update({
                time: candle.time,
                open: candle.open,
                high: candle.high,
                low: candle.low,
                close: candle.close,
            });
            displayPrice = candle.close;
        } else {
            displayPrice = interpolatePrice(this.candleMap, this.localDisplayTime, this.interval);
        }

        if (displayPrice != null) {
            this.updatePriceHeader({ price: { close: displayPrice }, candles: this.candles, name: this.slug, category: this.category });
        }

        var expectedDisplay = serverNow - this.delaySeconds;
        if (Math.abs(this.localDisplayTime - expectedDisplay) > 3 && Date.now() - this._lastResyncAt > 5000) {
            this.resync();
        }
    };

    MarketReplayChart.prototype.resync = function () {
        var self = this;
        if (this._resyncInFlight) {
            return Promise.resolve();
        }
        this._resyncInFlight = true;
        this._lastResyncAt = Date.now();
        this.setStatusState('resyncing');
        return this.fetchPayload().then(function (data) {
            if (data) self.applyPayload(data, true);
        }).finally(function () {
            self._resyncInFlight = false;
        });
    };

    MarketReplayChart.prototype.init = function () {
        var self = this;
        if (this.initialized) return Promise.resolve();

        return loadLightweightCharts().then(function (LC) {
            var t = chartTheme(self.theme);
            self.chart = LC.createChart(self.chartEl, {
                width: self.chartEl.clientWidth,
                height: self.height,
                layout: t.layout,
                grid: t.grid,
                rightPriceScale: { borderVisible: false },
                timeScale: { borderVisible: false, timeVisible: true, secondsVisible: self.interval === '1s' },
                crosshair: { mode: LC.CrosshairMode ? LC.CrosshairMode.Normal : 0 },
            });

            self.series = self.chart.addCandlestickSeries({
                upColor: t.upColor,
                downColor: t.downColor,
                borderUpColor: t.upColor,
                borderDownColor: t.downColor,
                wickUpColor: t.wickUpColor,
                wickDownColor: t.wickDownColor,
            });

            var ro = typeof ResizeObserver !== 'undefined'
                ? new ResizeObserver(function () {
                    if (self.chart && self.chartEl) {
                        self.chart.applyOptions({ width: self.chartEl.clientWidth });
                    }
                })
                : null;
            if (ro) ro.observe(self.chartEl);

            return self.fetchPayload();
        }).then(function (data) {
            self.applyPayload(data, false);
            self.initialized = true;

            self.tickTimer = setInterval(function () { self.onTick(); }, 1000);
            self.pollTimer = setInterval(function () { self.resync(); }, 15000);
        }).catch(function (err) {
            console.error('Market replay chart init failed:', err);
        });
    };

    var activeCharts = [];

    function bindGlobalLifecycle() {
        if (bindGlobalLifecycle._bound) return;
        bindGlobalLifecycle._bound = true;

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                activeCharts.forEach(function (inst) {
                    inst.paused = false;
                    inst.tickStartWall = Date.now();
                    inst.tickStartDisplay = inst.localDisplayTime;
                    inst.resync();
                });
            } else {
                activeCharts.forEach(function (inst) { inst.paused = true; });
            }
        });
        global.addEventListener('focus', function () {
            activeCharts.forEach(function (inst) { inst.resync(); });
        });
    }

    function initContainer(wrap) {
        if (wrap._replayInstance) return;
        bindGlobalLifecycle();
        var inst = new MarketReplayChart(wrap);
        wrap._replayInstance = inst;
        activeCharts.push(inst);
        inst.init();
    }

    function boot() {
        var nodes = document.querySelectorAll('[data-market-replay]');
        if (!nodes.length) return;

        var lazyNodes = [];
        nodes.forEach(function (wrap) {
            if (wrap.getAttribute('data-lazy') === '1') {
                lazyNodes.push(wrap);
            } else {
                initContainer(wrap);
            }
        });

        if (lazyNodes.length && 'IntersectionObserver' in global) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) {
                        if (entry.target._replayInstance) {
                            entry.target._replayInstance.paused = true;
                        }
                        return;
                    }
                    var wrap = entry.target;
                    if (!wrap._replayInstance) {
                        initContainer(wrap);
                    } else {
                        wrap._replayInstance.paused = false;
                        wrap._replayInstance.tickStartWall = Date.now();
                        wrap._replayInstance.tickStartDisplay = wrap._replayInstance.localDisplayTime;
                        wrap._replayInstance.resync();
                    }
                    observer.unobserve(wrap);
                });
            }, { rootMargin: '80px', threshold: 0.1 });

            lazyNodes.forEach(function (wrap) { observer.observe(wrap); });
        } else {
            lazyNodes.forEach(initContainer);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    global.BloombergMarketReplay = {
        init: boot,
        initContainer: initContainer,
    };
})(typeof window !== 'undefined' ? window : this);
