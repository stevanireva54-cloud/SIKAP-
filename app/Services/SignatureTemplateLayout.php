<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMXPath;
use PhpOffice\PhpWord\TemplateProcessor;
use RuntimeException;
use ZipArchive;

class SignatureTemplateLayout
{
    private const W = 'http://schemas.openxmlformats.org/wordprocessingml/2006/main';

    public static function processor(string $source, string $type): TemplateProcessor
    {
        $path = tempnam(sys_get_temp_dir(), 'arj_ttd_');
        if ($path === false) { throw new RuntimeException('Gagal membuat salinan template tanda tangan.'); }
        $zip = new ZipArchive();
        $opened = false;
        try {
            if (!copy($source, $path)) { throw new RuntimeException('Gagal menyalin template.'); }
            if ($zip->open($path) !== true) { throw new RuntimeException('Template Word tidak dapat dibuka.'); }
            $opened = true;
            $xml = $zip->getFromName('word/document.xml');
            if ($xml === false) { throw new RuntimeException('Isi template Word tidak ditemukan.'); }
            $doc = new DOMDocument();
            $doc->preserveWhiteSpace = true;
            if (!$doc->loadXML($xml, LIBXML_NONET)) { throw new RuntimeException('XML template tidak valid.'); }
            $xp = new DOMXPath($doc);
            $xp->registerNamespace('w', self::W);
            if ($type === 'berita_acara') { self::beritaAcara($doc, $xp); }
            elseif ($type === 'surat_tugas') { self::suratTugas($doc, $xp); }
            if (!$zip->addFromString('word/document.xml', $doc->saveXML())) { throw new RuntimeException('Gagal merapikan blok tanda tangan.'); }
            if (!$zip->close()) { throw new RuntimeException('Gagal menyimpan salinan template.'); }
            $opened = false;
            // TemplateProcessor menyalin dokumen ke file internalnya saat constructor.
            return new TemplateProcessor($path);
        } finally {
            if ($opened) { @$zip->close(); }
            if (is_file($path)) { @unlink($path); }
        }
    }

    private static function text(DOMXPath $xp, DOMElement $node): string
    {
        $text = '';
        foreach ($xp->query('.//w:t', $node) as $t) { $text .= $t->textContent; }
        return $text;
    }

    private static function element(DOMDocument $doc, string $name, array $attributes = []): DOMElement
    {
        $node = $doc->createElementNS(self::W, 'w:' . $name);
        foreach ($attributes as $key => $value) { $node->setAttributeNS(self::W, 'w:' . $key, (string) $value); }
        return $node;
    }

    private static function paragraph(DOMDocument $doc, string $text, ?DOMElement $example, string $align = 'center'): DOMElement
    {
        $p = self::element($doc, 'p');
        $props = self::element($doc, 'pPr');
        $props->appendChild(self::element($doc, 'jc', ['val' => $align]));
        $props->appendChild(self::element($doc, 'spacing', ['before' => 0, 'after' => 0]));
        $p->appendChild($props);
        $run = self::element($doc, 'r');
        if ($example !== null) {
            $xp = new DOMXPath($doc); $xp->registerNamespace('w', self::W);
            $rPr = $xp->query('.//w:r/w:rPr', $example)->item(0);
            if ($rPr) { $run->appendChild($rPr->cloneNode(true)); }
        }
        $t = self::element($doc, 't'); $t->appendChild($doc->createTextNode($text));
        $run->appendChild($t); $p->appendChild($run);
        return $p;
    }

    private static function table(DOMDocument $doc, array $widths): DOMElement
    {
        $table = self::element($doc, 'tbl');
        $props = self::element($doc, 'tblPr');
        $props->appendChild(self::element($doc, 'tblW', ['w' => array_sum($widths), 'type' => 'dxa']));
        $props->appendChild(self::element($doc, 'tblLayout', ['type' => 'fixed']));
        $borders = self::element($doc, 'tblBorders');
        foreach (['top', 'left', 'bottom', 'right', 'insideH', 'insideV'] as $edge) {
            $borders->appendChild(self::element($doc, $edge, ['val' => 'nil']));
        }
        $props->appendChild($borders);
        $margins = self::element($doc, 'tblCellMar');
        foreach (['top', 'left', 'bottom', 'right'] as $edge) { $margins->appendChild(self::element($doc, $edge, ['w' => 0, 'type' => 'dxa'])); }
        $props->appendChild($margins); $table->appendChild($props);
        $grid = self::element($doc, 'tblGrid');
        foreach ($widths as $width) { $grid->appendChild(self::element($doc, 'gridCol', ['w' => $width])); }
        $table->appendChild($grid);
        return $table;
    }

    private static function row(DOMDocument $doc, DOMElement $table, array $texts, array $widths, ?DOMElement $example, array $aligns = []): void
    {
        $row = self::element($doc, 'tr');
        foreach ($texts as $i => $text) {
            $cell = self::element($doc, 'tc'); $pr = self::element($doc, 'tcPr');
            $pr->appendChild(self::element($doc, 'tcW', ['w' => $widths[$i], 'type' => 'dxa']));
            $pr->appendChild(self::element($doc, 'vAlign', ['val' => 'center']));
            $cell->appendChild($pr);
            $cell->appendChild(self::paragraph($doc, $text, $example, $aligns[$i] ?? 'center'));
            $row->appendChild($cell);
        }
        $table->appendChild($row);
    }

    private static function beritaAcara(DOMDocument $doc, DOMXPath $xp): void
    {
        $signature = $name = $role = null;
        foreach ($xp->query('//w:body/w:p') as $p) {
            $text = self::text($xp, $p);
            if (str_contains($text, '${sig_gm}')) { $signature = $p; }
            if (str_contains($text, '${name_gm}')) { $name = $p; }
            if (str_contains($text, 'Field Coordinator') && str_contains($text, 'General Manager')) { $role = $p; }
        }
        if (!$signature || !$name || !$role) { throw new RuntimeException('Blok tanda tangan Berita Acara tidak sesuai template yang diperiksa.'); }
        $widths = [2160, 1440, 2160, 3600];
        $table = self::table($doc, $widths);
        $aligns = ['left', 'left', 'center', 'center'];
        self::row($doc, $table, ['${sig_fc}', '${sig_rs}', '${sig_gm}', '${sig_wsr}'], $widths, $signature, $aligns);
        self::row($doc, $table, ['${name_fc}', '${name_rs}', '${name_gm}', '${name_wsr}'], $widths, $name, $aligns);
        self::row($doc, $table, ['Field Coordinator', 'Rig Supt', 'General Manager', 'WSR'], $widths, $role, $aligns);
        // Pusat GM digeser melalui batas kolom, bukan indent negatif yang dapat terpotong oleh Word.
        // Pertahankan gambar/logo yang menempel pada paragraf nama.
        $drawings = $xp->query('.//w:drawing | .//w:pict', $name);
        if ($drawings->length) {
            $logoParagraph = $xp->query('./w:tr[2]/w:tc[3]/w:p', $table)->item(0);
            $drawingXp = new DOMXPath($doc);
            $drawingXp->registerNamespace('w', self::W);
            $drawingXp->registerNamespace('wp', 'http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing');
            $drawingXp->registerNamespace('a', 'http://schemas.openxmlformats.org/drawingml/2006/main');
            $margin = $xp->query('//w:body/w:sectPr/w:pgMar')->item(0);
            $leftMargin = $margin ? (int) $margin->getAttributeNS(self::W, 'left') : 1440;
            // 1 twip = 635 EMU. Gunakan pusat kolom GM, bukan offset logo lama.
            $center = ($leftMargin + $widths[0] + $widths[1] + $widths[2] / 2) * 635;
            // Logo Picture 7 berada di paragraf kosong, bukan pada paragraf nama.
            // Sesuaikan anchor gambar tubuh dokumen; garis nama ditangani terpisah.
            foreach ($drawingXp->query('//w:body//wp:anchor[.//a:blip]') as $logoAnchor) {
                $extent = $drawingXp->query('./wp:extent', $logoAnchor)->item(0);
                $position = $drawingXp->query('./wp:positionH', $logoAnchor)->item(0);
                if (!$extent || !$position) { continue; }
                $position->setAttribute('relativeFrom', 'page');
                $logoAnchor->setAttribute('layoutInCell', '0');
                while ($position->firstChild) { $position->removeChild($position->firstChild); }
                $position->appendChild($doc->createElementNS(
                    'http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing',
                    'wp:posOffset',
                    (string) (int) round($center - (int) $extent->getAttribute('cx') / 2)
                ));
            }

        }
        // WSR tetap di bawah judul asli. Gunakan indent positif di dalam kolom.
        foreach ($xp->query('./w:tr/w:tc[4]/w:p/w:pPr', $table) as $props) {
            $props->appendChild(self::element($doc, 'ind', ['left' => 1440, 'right' => 0]));
        }
        // Garis WSR menjadi border paragraf, sehingga tidak lagi melayang ke kanan.
        $wsrProps = $xp->query('./w:tr[2]/w:tc[4]/w:p/w:pPr', $table)->item(0);
        foreach ($xp->query('./w:ind', $wsrProps) as $indent) { $wsrProps->removeChild($indent); }
        $wsrProps->appendChild(self::element($doc, 'ind', ['left' => 1715, 'right' => 275]));
        $border = self::element($doc, 'pBdr');
        $border->appendChild(self::element($doc, 'bottom', ['val' => 'single', 'sz' => 4, 'space' => 0, 'color' => '808080']));
        $wsrProps->appendChild($border);
        $signature->parentNode->insertBefore($table, $signature);
        foreach ([$signature, $name, $role] as $old) { $old->parentNode->removeChild($old); }
    }

    private static function suratTugas(DOMDocument $doc, DOMXPath $xp): void
    {
        // Pertahankan tabel, nama gabungan, jabatan, warna, dan jarak template asli.
        // Hanya tanda tangan Area Manager yang sebelumnya rata kanan diubah rata kiri.
        foreach ($xp->query('//w:tbl/w:tr/w:tc/w:p') as $paragraph) {
            if (!str_contains(self::text($xp, $paragraph), '${s_am}')) { continue; }
            $props = $xp->query('./w:pPr', $paragraph)->item(0);
            if (!$props) {
                $props = self::element($doc, 'pPr');
                $paragraph->insertBefore($props, $paragraph->firstChild);
            }
            $alignment = $xp->query('./w:jc', $props)->item(0);
            if (!$alignment) {
                $alignment = self::element($doc, 'jc');
                $props->appendChild($alignment);
            }
            $alignment->setAttributeNS(self::W, 'w:val', 'left');
            // Perataan kiri saja tidak mengubah awal kolom ketiga.
            // Kurangi ruang kolom kedua 720 twip (36 pt); awal kolom 1/2 tetap.
            $cell = $paragraph->parentNode;
            $row = $cell->parentNode;
            $table = $row->parentNode;
            $secondWidth = $xp->query('./w:tc[2]/w:tcPr/w:tcW', $row)->item(0);
            $secondGrid = $xp->query('./w:tblGrid/w:gridCol[2]', $table)->item(0);
            if ($secondWidth && $secondGrid) {
                $width = max(697, (int) $secondWidth->getAttributeNS(self::W, 'w') - 720);
                $secondWidth->setAttributeNS(self::W, 'w:w', (string) $width);
                $secondGrid->setAttributeNS(self::W, 'w:w', (string) $width);
                $propsTable = $xp->query('./w:tblPr', $table)->item(0);
                $layout = $xp->query('./w:tblLayout', $propsTable)->item(0);
                if (!$layout) { $layout = self::element($doc, 'tblLayout'); $propsTable->appendChild($layout); }
                $layout->setAttributeNS(self::W, 'w:type', 'fixed');
                $total = 0;
                foreach ($xp->query('./w:tblGrid/w:gridCol', $table) as $col) { $total += (int) $col->getAttributeNS(self::W, 'w'); }
                $tableWidth = $xp->query('./w:tblW', $propsTable)->item(0);
                if ($tableWidth) {
                    $tableWidth->setAttributeNS(self::W, 'w:w', (string) $total);
                    $tableWidth->setAttributeNS(self::W, 'w:type', 'dxa');
                }
            }
            // Nama, jabatan, dan tabel tanda tangan memakai pusat sel induk yang sama.
            $tableProps = $xp->query('./w:tblPr', $table)->item(0);
            $tableAlign = $xp->query('./w:jc', $tableProps)->item(0);
            if (!$tableAlign) { $tableAlign = self::element($doc, 'jc'); $tableProps->appendChild($tableAlign); }
            $tableAlign->setAttributeNS(self::W, 'w:val', 'center');
            foreach ($xp->query('./w:p', $table->parentNode) as $textParagraph) {
                $text = self::text($xp, $textParagraph);
                if (!str_contains($text, '${name_tp}') && !str_contains($text, 'Tool Pusher / Rig Supt / Area Manager')) { continue; }
                $textProps = $xp->query('./w:pPr', $textParagraph)->item(0);
                if (!$textProps) { $textProps = self::element($doc, 'pPr'); $textParagraph->insertBefore($textProps, $textParagraph->firstChild); }
                $textAlign = $xp->query('./w:jc', $textProps)->item(0);
                if (!$textAlign) { $textAlign = self::element($doc, 'jc'); $textProps->appendChild($textAlign); }
                $textAlign->setAttributeNS(self::W, 'w:val', 'center');
            }
            return;
        }
        throw new RuntimeException('Placeholder tanda tangan Area Manager tidak ditemukan pada template Surat Tugas.');
    }
}
