<?php
/**
 * Market replay data provider interface.
 */

interface MarketReplayProviderInterface
{
    /** @return string e.g. binance, yahoo */
    public function getName(): string;

    /**
     * Fetch normalized OHLC candles between unix timestamps (seconds, inclusive start).
     *
     * @return array<int, array{time:int,open:float,high:float,low:float,close:float,volume:float}>
     */
    public function fetchCandles(string $symbol, string $interval, int $fromTs, int $toTs): array;
}
