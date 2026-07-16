<?php
/**
 * Build a 1200×630 Open Graph image for link previews.
 *
 * Prefers uploads/images/crypto-assets.jpg|png as the background (as requested),
 * overlays brand text, and writes uploads/images/og-image.jpg (+ .png when possible).
 *
 * Usage (CLI or browser as admin-only optional):
 *   php scripts/generate-og-image.php
 *   php scripts/generate-og-image.php "Stock Wealth" "Multi-Asset Investment Platform"
 */

declare(strict_types=1);

$root = dirname(__DIR__);
require_once $root . '/includes/helpers.php';

if (!function_exists('imagecreatetruecolor')) {
    fwrite(STDERR, "GD extension is required to generate og-image.\n");
    exit(1);
}

$siteName = $argv[1] ?? get_site_name();
$tagline = $argv[2] ?? 'Multi-Asset Investment Platform';
$accent = $argv[3] ?? 'Secure · Intelligent · Global';

$width = 1200;
$height = 630;
$outJpg = $root . '/uploads/images/og-image.jpg';
$outPng = $root . '/uploads/images/og-image.png';

$bgCandidates = [
    $root . '/uploads/images/crypto-assets.jpg',
    $root . '/uploads/images/crypto-assets.png',
    $root . '/uploads/images/chart_bg.jpg',
    $root . '/uploads/images/banner_bg.jpg',
];

$bgPath = null;
foreach ($bgCandidates as $candidate) {
    if (is_file($candidate)) {
        $bgPath = $candidate;
        break;
    }
}

$canvas = imagecreatetruecolor($width, $height);
if ($canvas === false) {
    fwrite(STDERR, "Unable to create canvas.\n");
    exit(1);
}

$navy = imagecolorallocate($canvas, 8, 20, 34);
$blue = imagecolorallocate($canvas, 75, 142, 255);
$white = imagecolorallocate($canvas, 255, 255, 255);
$muted = imagecolorallocate($canvas, 193, 198, 215);
imagefilledrectangle($canvas, 0, 0, $width, $height, $navy);

if ($bgPath !== null) {
    $ext = strtolower(pathinfo($bgPath, PATHINFO_EXTENSION));
    $bg = null;
    if ($ext === 'png') {
        $bg = @imagecreatefrompng($bgPath);
    } elseif (in_array($ext, ['jpg', 'jpeg'], true)) {
        $bg = @imagecreatefromjpeg($bgPath);
    } elseif ($ext === 'webp' && function_exists('imagecreatefromwebp')) {
        $bg = @imagecreatefromwebp($bgPath);
    }
    if ($bg) {
        $bw = imagesx($bg);
        $bh = imagesy($bg);
        $scale = max($width / max(1, $bw), $height / max(1, $bh));
        $dw = (int) round($bw * $scale);
        $dh = (int) round($bh * $scale);
        $dx = (int) round(($width - $dw) / 2);
        $dy = (int) round(($height - $dh) / 2);
        imagecopyresampled($canvas, $bg, $dx, $dy, 0, 0, $dw, $dh, $bw, $bh);
        imagedestroy($bg);
    }
}

// Dark overlay for readable text
for ($i = 0; $i < 8; $i++) {
    $alpha = 90 - ($i * 6);
    if ($alpha < 40) {
        $alpha = 40;
    }
    $overlay = imagecolorallocatealpha($canvas, 4, 10, 20, $alpha);
    imagefilledrectangle($canvas, 0, (int) ($height * $i / 10), $width, $height, $overlay);
}

// Accent bar
imagefilledrectangle($canvas, 0, 0, $width, 8, $blue);

$fontBold = null;
$fontRegular = null;
$fontCandidates = [
    'C:/Windows/Fonts/arialbd.ttf',
    'C:/Windows/Fonts/segoeuib.ttf',
    'C:/Windows/Fonts/arial.ttf',
    '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
    '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
    '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
];
foreach ($fontCandidates as $font) {
    if (!is_file($font)) {
        continue;
    }
    if ($fontBold === null && (stripos($font, 'bold') !== false || stripos($font, 'bd') !== false)) {
        $fontBold = $font;
    }
    if ($fontRegular === null) {
        $fontRegular = $font;
    }
}
if ($fontBold === null) {
    $fontBold = $fontRegular;
}

function og_center_text($img, string $text, int $size, int $y, $color, ?string $font): void
{
    $width = imagesx($img);
    if ($font && function_exists('imagettfbbox')) {
        $box = imagettfbbox($size, 0, $font, $text);
        $tw = abs($box[2] - $box[0]);
        $x = (int) (($width - $tw) / 2);
        imagettftext($img, $size, 0, $x, $y, $color, $font, $text);
        return;
    }
    $tw = imagefontwidth(5) * strlen($text);
    $x = (int) (($width - $tw) / 2);
    imagestring($img, 5, $x, $y - 12, $text, $color);
}

og_center_text($canvas, strtoupper($siteName), 64, 250, $white, $fontBold);
og_center_text($canvas, $tagline, 28, 330, $muted, $fontRegular);
og_center_text($canvas, strtoupper($accent), 18, 400, $blue, $fontBold);

// Soft logo badge
$badgeX = (int) ($width / 2);
$badgeY = 480;
imagefilledellipse($canvas, $badgeX, $badgeY, 70, 70, $blue);
imagefilledellipse($canvas, $badgeX, $badgeY, 54, 54, $navy);
og_center_text($canvas, 'SW', 18, $badgeY + 7, $white, $fontBold);

if (!is_dir(dirname($outJpg))) {
    mkdir(dirname($outJpg), 0755, true);
}

$okJpg = imagejpeg($canvas, $outJpg, 86);
$okPng = imagepng($canvas, $outPng, 6);
imagedestroy($canvas);

if (!$okJpg && !$okPng) {
    fwrite(STDERR, "Failed to write OG image.\n");
    exit(1);
}

echo "OG image written:\n";
if ($okJpg) {
    echo " - {$outJpg}\n";
}
if ($okPng) {
    echo " - {$outPng}\n";
}
echo "Background used: " . ($bgPath ?? 'solid brand navy') . "\n";
