<?php
class ReportsController {
    public function index() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        $reports = [
            ["title" => "Monthly Engagement Report",  "date" => "March 2026",   "type" => "PDF",  "file" => "monthly_engagement.pdf"],
            ["title" => "Platform Comparison",         "date" => "Last 30 days", "type" => "CSV",  "file" => "platform_comparison.csv"],
            ["title" => "Audience Growth Report",      "date" => "Q1 2026",      "type" => "XLSX", "file" => "audience_growth.xlsx"],
        ];

        require "views/reports/index.php";
    }

    public function download() {
        if (!isLoggedIn()) redirect(BASE_URL . "index.php?controller=auth&action=login");

        $allowed = ["monthly_engagement.pdf", "platform_comparison.csv", "audience_growth.xlsx"];
        $file    = basename($_GET["file"] ?? "");

        if (!in_array($file, $allowed)) {
            http_response_code(404);
            die("File not found.");
        }

        if (!is_dir("downloads")) {
            mkdir("downloads", 0755, true);
        }

        $path = "downloads/" . $file;

        if (!file_exists($path)) {
            $this->generateFile($file, $path);
        }

        $ext  = pathinfo($file, PATHINFO_EXTENSION);
        $mime = match($ext) {
            "pdf"  => "application/pdf",
            "csv"  => "text/csv",
            "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            default => "application/octet-stream",
        };

        header("Content-Type: $mime");
        header("Content-Disposition: attachment; filename=\"$file\"");
        header("Content-Length: " . filesize($path));
        header("Cache-Control: no-cache");
        readfile($path);
        exit;
    }

    private function generateFile($file, $path) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if ($ext === "csv") {
            $csv  = "Platform,Followers,Engagement Rate (%),Posts,Reach,Recorded At\n";
            $csv .= "Facebook,12450,8.4,45,48000,2026-03-27\n";
            $csv .= "Instagram,8750,12.7,32,32000,2026-03-27\n";
            $csv .= "Twitter,3200,5.2,68,15000,2026-03-27\n";
            $csv .= "LinkedIn,1850,9.1,12,9000,2026-03-27\n";
            $csv .= "YouTube,4200,7.3,18,145000,2026-03-27\n";
            file_put_contents($path, $csv);

        } elseif ($ext === "xlsx") {
            $this->buildXlsx($path);

        } elseif ($ext === "pdf") {
            $this->buildPdf($path);
        }
    }

    // ── Minimal hand-built PDF (unchanged) ───────────────────────────────────
    private function buildPdf($path) {
        $rows = [
            ["Platform",   "Followers", "Engagement%", "Posts", "Reach"],
            ["Facebook",   "12,450",    "8.4",         "45",    "48,000"],
            ["Instagram",  "8,750",     "12.7",        "32",    "32,000"],
            ["Twitter",    "3,200",     "5.2",         "68",    "15,000"],
            ["LinkedIn",   "1,850",     "9.1",         "12",    "9,000"],
            ["YouTube",    "4,200",     "7.3",         "18",    "145,000"],
            ["TOTAL",      "30,450",    "8.5 avg",     "175",   "249,000"],
        ];

        $title   = "Monthly Engagement Report - March 2026";
        $lines   = [];
        $lines[] = "BT /F1 14 Tf 50 780 Td ($title) Tj ET";
        $lines[] = "BT /F1 10 Tf 50 755 Td (Generated: " . date("Y-m-d H:i:s") . ") Tj ET";
        $lines[] = "50 745 m 550 745 l S";

        $y = 725;
        foreach ($rows as $i => $row) {
            $x    = 50;
            $cols = [100, 80, 90, 60, 80];
            foreach ($row as $ci => $cell) {
                $safe    = str_replace(['(', ')', '\\'], ['\(', '\)', '\\\\'], $cell);
                $weight  = ($i === 0 || $i === count($rows) - 1) ? "/F1 10" : "/F1 9";
                $lines[] = "BT $weight Tf $x $y Td ($safe) Tj ET";
                $x += $cols[$ci] ?? 80;
            }
            $y -= 20;
            if ($i === 0) {
                $lines[] = "50 " . ($y + 15) . " m 550 " . ($y + 15) . " l S";
            }
        }

        $stream = implode("\n", $lines);
        $sLen   = strlen($stream);

        $pdf  = "%PDF-1.4\n";
        $pdf .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
        $pdf .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
        $pdf .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 842]\n";
        $pdf .= "   /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
        $pdf .= "4 0 obj\n<< /Length $sLen >>\nstream\n$stream\nendstream\nendobj\n";
        $pdf .= "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

        $offsets = [];
        $pos     = 0;
        foreach (explode("\n", $pdf) as $line) {
            if (preg_match('/^(\d+) 0 obj$/', $line, $m)) {
                $offsets[(int)$m[1]] = $pos;
            }
            $pos += strlen($line) + 1;
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 6\n0000000000 65535 f \n";
        for ($i = 1; $i <= 5; $i++) {
            $pdf .= str_pad($offsets[$i] ?? 0, 10, "0", STR_PAD_LEFT) . " 00000 n \n";
        }
        $pdf .= "trailer\n<< /Size 6 /Root 1 0 R >>\n";
        $pdf .= "startxref\n$xrefOffset\n%%EOF";

        file_put_contents($path, $pdf);
    }

    // ── XLSX built with a pure-PHP ZIP writer (no ZipArchive needed) ─────────
    private function buildXlsx($path) {
        $rows = [
            ["Platform", "Followers", "Engagement Rate (%)", "Posts", "Reach", "Period"],
            ["Facebook",  12450, 8.4,  45,  48000,  "Q1 2026"],
            ["Instagram", 8750,  12.7, 32,  32000,  "Q1 2026"],
            ["Twitter",   3200,  5.2,  68,  15000,  "Q1 2026"],
            ["LinkedIn",  1850,  9.1,  12,  9000,   "Q1 2026"],
            ["YouTube",   4200,  7.3,  18,  145000, "Q1 2026"],
        ];

        // ── Build XML file contents ──────────────────────────────────────────
        $letters  = ['A','B','C','D','E','F'];
        $sheetXml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetData>';

        foreach ($rows as $ri => $row) {
            $rowNum    = $ri + 1;
            $sheetXml .= "<row r=\"$rowNum\">";
            foreach ($row as $ci => $cell) {
                $ref = $letters[$ci] . $rowNum;
                if (is_numeric($cell)) {
                    $sheetXml .= "<c r=\"$ref\"><v>$cell</v></c>";
                } else {
                    $esc       = htmlspecialchars($cell, ENT_XML1);
                    $sheetXml .= "<c r=\"$ref\" t=\"inlineStr\"><is><t>$esc</t></is></c>";
                }
            }
            $sheetXml .= "</row>";
        }
        $sheetXml .= '</sheetData></worksheet>';

        $workbookXml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"'
            . ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Audience Growth" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';

        $relsXml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1"'
            . ' Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet"'
            . ' Target="worksheets/sheet1.xml"/>'
            . '</Relationships>';

        $contentTypes = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml"  ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml"'
            . ' ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml"'
            . ' ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '</Types>';

        $topRels = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1"'
            . ' Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument"'
            . ' Target="xl/workbook.xml"/>'
            . '</Relationships>';

        // ── Pack everything into a ZIP using pure PHP ────────────────────────
        $files = [
            "[Content_Types].xml"        => $contentTypes,
            "_rels/.rels"                => $topRels,
            "xl/workbook.xml"            => $workbookXml,
            "xl/_rels/workbook.xml.rels" => $relsXml,
            "xl/worksheets/sheet1.xml"   => $sheetXml,
        ];

        file_put_contents($path, $this->buildZip($files));
    }

    /**
     * Build a ZIP archive in memory from an associative array of
     * [ 'path/in/zip' => 'file contents' ] and return the raw bytes.
     * Uses STORE (no compression) so there is no dependency on zlib either.
     */
    private function buildZip(array $files): string {
        $centralDir = '';
        $localPart  = '';
        $offset     = 0;
        $entries    = [];

        foreach ($files as $name => $data) {
            $nameBytes = $name;
            $nameLen   = strlen($nameBytes);
            $dataLen   = strlen($data);
            $crc       = crc32($data);
            $dosTime   = $this->dosTime();

            // Local file header
            $local  = pack('V', 0x04034b50);   // signature
            $local .= pack('v', 20);            // version needed
            $local .= pack('v', 0);             // flags
            $local .= pack('v', 0);             // compression: STORE
            $local .= pack('V', $dosTime);      // last mod date/time
            $local .= pack('V', $crc);          // CRC-32
            $local .= pack('V', $dataLen);      // compressed size
            $local .= pack('V', $dataLen);      // uncompressed size
            $local .= pack('v', $nameLen);      // file name length
            $local .= pack('v', 0);             // extra field length
            $local .= $nameBytes;
            $local .= $data;

            $entries[] = [
                'name'    => $nameBytes,
                'nameLen' => $nameLen,
                'crc'     => $crc,
                'size'    => $dataLen,
                'offset'  => $offset,
                'dosTime' => $dosTime,
            ];

            $localPart .= $local;
            $offset    += strlen($local);
        }

        // Central directory
        foreach ($entries as $e) {
            $cd  = pack('V', 0x02014b50);   // signature
            $cd .= pack('v', 20);           // version made by
            $cd .= pack('v', 20);           // version needed
            $cd .= pack('v', 0);            // flags
            $cd .= pack('v', 0);            // compression
            $cd .= pack('V', $e['dosTime']);
            $cd .= pack('V', $e['crc']);
            $cd .= pack('V', $e['size']);   // compressed
            $cd .= pack('V', $e['size']);   // uncompressed
            $cd .= pack('v', $e['nameLen']);
            $cd .= pack('v', 0);            // extra length
            $cd .= pack('v', 0);            // comment length
            $cd .= pack('v', 0);            // disk number start
            $cd .= pack('v', 0);            // int file attributes
            $cd .= pack('V', 0);            // ext file attributes
            $cd .= pack('V', $e['offset']); // local header offset
            $cd .= $e['name'];
            $centralDir .= $cd;
        }

        $cdLen    = strlen($centralDir);
        $cdOffset = strlen($localPart);
        $count    = count($entries);

        // End of central directory record
        $eocd  = pack('V', 0x06054b50);  // signature
        $eocd .= pack('v', 0);           // disk number
        $eocd .= pack('v', 0);           // disk with CD
        $eocd .= pack('v', $count);      // entries on disk
        $eocd .= pack('v', $count);      // total entries
        $eocd .= pack('V', $cdLen);      // size of CD
        $eocd .= pack('V', $cdOffset);   // offset of CD
        $eocd .= pack('v', 0);           // comment length

        return $localPart . $centralDir . $eocd;
    }

    /** DOS-format date/time packed into a single 32-bit int. */
    private function dosTime(): int {
        $t = getdate();
        return (($t['year'] - 1980) << 25)
             | ($t['mon']           << 21)
             | ($t['mday']          << 16)
             | ($t['hours']         << 11)
             | ($t['minutes']       << 5)
             | ($t['seconds']       >> 1);
    }
}
?>