<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['document_title'] }}</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            color: #000000;
            background: #ffffff;
            font-size: 9.4pt;
            line-height: 1.08;
        }

        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            overflow: hidden;
            padding: 5.5mm 7.5mm 4mm 7.5mm;
            background: #ffffff;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        /* =========================================================
           HEADER
        ========================================================= */
        .header-table {
            width: 100%;
            table-layout: fixed;
            margin: 0 0 3.2mm 0;
            font-size: 6.8pt;
            line-height: 1;
        }

        .header-table td {
            border: 0.25mm solid #000000;
            padding: 0.45mm 0.8mm;
            vertical-align: middle;
            color: #000000;
        }

        .header-left {
            width: 22%;
        }

        .header-center {
            width: 56%;
            text-align: center;
        }

        .header-logo {
            width: 22%;
            text-align: center;
        }

        .header-logo img {
            display: block;
            width: 26mm;
            max-height: 11mm;
            margin: 0 auto;
        }

        .doc-number {
            font-weight: bold;
            font-style: italic;
            font-size: 7pt;
        }

        .csms {
            font-weight: bold;
            font-size: 7.8pt;
        }

        .form-name {
            font-weight: bold;
            font-size: 7.7pt;
        }

        .form-no {
            font-weight: bold;
            font-size: 7.2pt;
        }

        .small-head {
            font-size: 5.8pt;
            font-style: italic;
            font-weight: bold;
            text-align: center;
        }

        .small-value {
            font-size: 5.8pt;
            font-weight: bold;
            text-align: center;
        }

        /* =========================================================
           BODY
        ========================================================= */
        .body {
            padding: 0 2mm;
        }

        p {
            margin: 0;
        }

        .address {
            margin-bottom: 2.2mm;
            line-height: 1.08;
        }

        .address p {
            margin: 0 0 0.35mm 0;
        }

        .subject {
            margin: 0 0 1.1mm 0;
        }

        .subject strong {
            display: inline-block;
            width: 31mm;
        }

        .person-intro {
            margin-bottom: 0.7mm;
        }

        .person-table {
            width: 100%;
            margin: 0 0 1.0mm 0;
            font-size: 9.4pt;
            line-height: 1.05;
        }

        .person-table td {
            border: none;
            padding: 0.20mm 0;
            vertical-align: top;
            color: #000000;
        }

        .person-label {
            width: 31mm;
        }

        .person-colon {
            width: 4mm;
            text-align: center;
        }

        .person-value {
            font-weight: bold;
            font-style: italic;
            color: #123f7a;
        }

        .replace-line {
            padding-top: 0.35mm !important;
            padding-bottom: 0.35mm !important;
        }

        .mentor-title {
            margin: 0.6mm 0 0.45mm 0;
            font-weight: bold;
        }

        .mentor-note {
            margin: 2.7mm 0 0.9mm 0;
            font-size: 8.8pt;
            line-height: 1.05;
        }

        /* =========================================================
           CHECKLIST
        ========================================================= */
        .checklist {
            width: 100%;
            margin: 0;
            table-layout: fixed;
            border: 0.28mm solid #000000;
            font-size: 7.2pt;
            line-height: 1;
            color: #000000;
        }

        .checklist td {
            border: none;
            padding: 0.28mm 0.45mm;
            vertical-align: middle;
            color: #000000;
        }

        .checklist-title {
            height: 5.2mm;
            border-bottom: 0.28mm solid #000000 !important;
            padding: 0 !important;
            text-align: center;
            vertical-align: middle !important;
            font-size: 7.8pt;
            font-weight: normal;
        }

        .check-no {
            width: 8mm;
            padding-right: 1.4mm !important;
            text-align: right;
        }

        .check-name {
            width: 26mm;
            white-space: nowrap;
        }

        .box-cell {
            width: 9mm;
            min-width: 9mm;
            padding-left: 0.3mm !important;
            padding-right: 0.6mm !important;
        }

        .status-box {
            display: block;
            width: 7.7mm;
            height: 6.4mm;
            line-height: 6.0mm;
            margin: 0;
            border: 0.28mm solid #000000;
            text-align: center;
            vertical-align: middle;
            background: #ffffff;
            color: #000000;
            font-size: 7.2pt;
            font-weight: normal;
            overflow: hidden;
        }

        .cert-cell {
            padding: 0 !important;
        }

        .cert-grid {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
        }

        .cert-grid td {
            border: none !important;
            padding: 0.17mm 0.55mm 0.17mm 0 !important;
            white-space: nowrap;
            vertical-align: middle;
            font-size: 6.8pt;
        }

        .cert-label {
            text-align: left;
        }

        .cert-grid .box-cell {
            width: 8.8mm !important;
            min-width: 8.8mm !important;
            padding-right: 0.9mm !important;
        }

        .yn-wrap {
            padding-left: 1.4mm !important;
        }

        .yn-table {
            width: auto;
            border-collapse: collapse;
        }

        .yn-table td {
            border: none !important;
            padding: 0.10mm 0.55mm !important;
            white-space: nowrap;
            vertical-align: middle;
            text-align: center;
            font-size: 6.8pt;
        }

        .yn-table .box-cell {
            width: 8.7mm !important;
            min-width: 8.7mm !important;
        }

        .yn-label {
            min-width: 7mm;
        }

        .check-note {
            padding-top: 0.45mm !important;
            font-weight: bold;
        }

        .check-note-text,
        .legend {
            padding-left: 4.6mm !important;
            font-size: 6.9pt;
        }

        .legend {
            padding-bottom: 0.55mm !important;
            font-weight: bold;
        }

        /* =========================================================
           CLOSING
        ========================================================= */
        .thanks {
            margin: 1.05mm 0 2.5mm 0;
            font-size: 9pt;
        }

        .date-block {
            margin: 0 0 1.6mm 0;
            font-size: 9pt;
            line-height: 1.12;
        }

        .date-strong {
            font-weight: bold;
            font-style: italic;
            color: #123f7a;
        }

        /* =========================================================
           SIGNATURE
        ========================================================= */
        .signature-table {
            width: 100%;
            table-layout: fixed;
            margin-top: 0;
            font-size: 8.8pt;
            line-height: 1;
        }

        .signature-table td {
            border: none;
            padding: 0;
            vertical-align: top;
            color: #000000;
        }

        .sig-left {
            width: 42%;
        }

        .sig-right {
            width: 58%;
        }

        .sig-heading-left {
            height: 5mm;
            text-align: left;
        }

        .sig-heading-right {
            height: 5mm;
            text-align: center;
        }

        .sig-left-image-area {
            height: 20mm;
            vertical-align: bottom !important;
        }

        .sig-left-image {
            display: block;
            max-width: 25mm;
            max-height: 18mm;
            margin: 0 0 0 0;
        }

        .sig-left-name-wrap {
            width: 35mm;
            text-align: center;
        }

        .sig-name {
            font-weight: bold;
            font-style: italic;
            text-decoration: underline;
            white-space: nowrap;
            color: #123f7a;
        }

        .sig-role {
            margin-top: 0.5mm;
            font-weight: bold;
            white-space: nowrap;
            color: #123f7a;
        }

        .right-signatures {
            width: 100%;
            table-layout: fixed;
        }

        .right-signatures td {
            width: 33.333%;
            height: 20mm;
            padding: 0 1mm;
            vertical-align: bottom;
            text-align: center;
        }

        .right-signatures img {
            display: block;
            max-width: 25mm;
            max-height: 18mm;
            margin: 0 auto;
        }

        .right-names {
            margin-top: 0.7mm;
            text-align: center;
            font-size: 8.1pt;
            font-weight: bold;
            font-style: italic;
            text-decoration: underline;
            white-space: nowrap;
            color: #123f7a;
        }

        .right-roles {
            margin-top: 0.55mm;
            text-align: center;
            font-size: 8.1pt;
            font-weight: bold;
            font-style: italic;
            white-space: nowrap;
            color: #123f7a;
        }

        /* Target reference only has the thin orange line at bottom.
           No company-info/ISO block here, so wkhtmltopdf cannot create
           the oversized ISO second page. */
        .bottom-orange-line {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 0.8mm;
            background: #f58220;
        }
    
        /* =========================================================
           FINAL MATCH TO REFERENCE
        ========================================================= */
        .page {
            padding: 5.5mm 8.5mm 20mm 8.5mm !important;
        }

        .body {
            padding: 0 1.4mm !important;
        }

        .address,
        .subject,
        .person-intro,
        .person-table,
        .mentor-title,
        .mentor-note,
        .checklist,
        .thanks,
        .date-block,
        .signature-table {
            color: #000000 !important;
        }

        .subject {
            font-size: 8.8pt !important;
            margin-bottom: 0.8mm !important;
        }

        .person-intro {
            font-size: 8.5pt !important;
            margin-bottom: 0.45mm !important;
        }

        .person-table {
            font-size: 8.6pt !important;
            line-height: 1.02 !important;
            margin-bottom: 0.7mm !important;
        }

        .person-table td {
            padding: 0.14mm 0 !important;
        }

        .person-value {
            color: #173f78 !important;
            font-weight: 700 !important;
            font-style: italic !important;
        }

        .mentor-title {
            font-size: 8.4pt !important;
            margin-top: 0.45mm !important;
        }

        /* The official reference leaves a visible gap before the mentor note. */
        .mentor-note {
            margin: 10.8mm 0 0.75mm 0 !important;
            font-size: 7.4pt !important;
            line-height: 1 !important;
        }

        .checklist {
            font-size: 5.95pt !important;
            line-height: .96 !important;
        }

        .checklist td {
            padding: 0.16mm 0.32mm !important;
        }

        .checklist-title {
            height: 4.2mm !important;
            font-size: 6.8pt !important;
            padding: 0 !important;
        }

        .check-no {
            width: 7mm !important;
            padding-right: 1mm !important;
        }

        .check-name {
            width: 22mm !important;
        }

        .box-cell {
            width: 7mm !important;
            min-width: 7mm !important;
            padding: 0.08mm 0.28mm !important;
        }

        .status-box {
            width: 5.8mm !important;
            min-width: 5.8mm !important;
            height: 5.4mm !important;
            line-height: 5mm !important;
            font-size: 5.9pt !important;
            border: 0.25mm solid #000000 !important;
        }

        .cert-grid td {
            padding: 0.09mm 0.35mm 0.09mm 0 !important;
            font-size: 5.45pt !important;
        }

        .cert-grid .box-cell {
            width: 6.7mm !important;
            min-width: 6.7mm !important;
            padding-right: 0.45mm !important;
        }

        .yn-wrap {
            padding-left: 0.7mm !important;
        }

        .yn-table td {
            padding: 0.05mm 0.32mm !important;
            font-size: 5.6pt !important;
        }

        .yn-table .box-cell {
            width: 6.7mm !important;
            min-width: 6.7mm !important;
        }

        .yn-label {
            min-width: 5.2mm !important;
        }

        .check-note {
            padding-top: 0.22mm !important;
            font-size: 5.8pt !important;
        }

        .check-note-text,
        .legend {
            padding-left: 3.8mm !important;
            font-size: 5.55pt !important;
            line-height: 1 !important;
        }

        .legend {
            padding-bottom: 0.3mm !important;
        }

        .thanks {
            margin: 0.85mm 0 2.0mm 0 !important;
            font-size: 7.7pt !important;
        }

        .date-block {
            font-size: 7.6pt !important;
            line-height: 1.05 !important;
            margin-bottom: 1.3mm !important;
        }

        .date-strong {
            color: #173f78 !important;
        }

        .signature-table {
            font-size: 7.7pt !important;
            line-height: 1 !important;
        }

        .sig-heading-left,
        .sig-heading-right {
            height: 4.3mm !important;
        }

        .sig-left-image-area {
            height: 15.5mm !important;
        }

        .sig-left-image {
            max-width: 20mm !important;
            max-height: 13.5mm !important;
        }

        .right-signatures td {
            height: 15.5mm !important;
            padding: 0 0.7mm !important;
        }

        .right-signatures img {
            max-width: 20mm !important;
            max-height: 13.5mm !important;
        }

        .sig-left-name-wrap {
            width: 29mm !important;
        }

        .sig-name,
        .sig-role,
        .right-names,
        .right-roles {
            color: #173f78 !important;
        }

        .sig-name {
            font-size: 6.9pt !important;
        }

        .sig-role {
            margin-top: 0.25mm !important;
            font-size: 6.7pt !important;
        }

        .right-names {
            margin-top: 0.35mm !important;
            font-size: 6.6pt !important;
        }

        .right-roles {
            margin-top: 0.25mm !important;
            font-size: 6.4pt !important;
        }

        .footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 18mm;
            background: #f58220;
            color: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            overflow: hidden;
        }

        .footer-info {
            position: absolute;
            left: 8mm;
            right: 44mm;
            top: 2.3mm;
            text-align: center;
        }

        .footer-company {
            margin-bottom: 0.55mm;
            font-size: 7.2pt;
            font-weight: 700;
            letter-spacing: .1px;
        }

        .footer-text {
            font-size: 5.7pt;
            line-height: 1.22;
        }

        .footer-iso {
            position: absolute;
            right: 5mm;
            top: 2.7mm;
            width: 34mm;
            height: 12.5mm;
            text-align: right;
            overflow: hidden;
        }

        .footer-iso img {
            display: block !important;
            width: auto !important;
            height: auto !important;
            max-width: 34mm !important;
            max-height: 12.5mm !important;
            margin: 0 0 0 auto !important;
            border: 0 !important;
            object-fit: contain !important;
        }

        .bottom-orange-line {
            display: none !important;
        }

    
        /* =========================================================
           FINAL LOWER-AREA MATCH V3
           Revisi khusus area yang ditandai:
           - matrix sertifikat
           - Note / Legend
           - jarak bawah + signature + footer
        ========================================================= */

        /* Checklist dibuat lebih tinggi dan tidak terlalu "gepeng". */
        .checklist {
            font-size: 6.45pt !important;
            line-height: 1.05 !important;
        }

        .checklist td {
            padding-top: 0.34mm !important;
            padding-bottom: 0.34mm !important;
        }

        .checklist-title {
            height: 4.8mm !important;
            font-size: 7.1pt !important;
            line-height: 1 !important;
        }

        .check-no {
            width: 7.5mm !important;
        }

        .check-name {
            width: 23.5mm !important;
        }

        .status-box {
            width: 6.4mm !important;
            min-width: 6.4mm !important;
            height: 5.8mm !important;
            line-height: 5.35mm !important;
            font-size: 6.2pt !important;
        }

        /* Matrix sertifikat mengikuti contoh: rapat, tidak ditarik memenuhi lebar. */
        .cert-cell {
            padding-left: 0.8mm !important;
            padding-right: 0 !important;
        }

        .cert-grid {
            width: auto !important;
            table-layout: auto !important;
            margin: 0 !important;
        }

        .cert-grid td {
            padding-top: 0.18mm !important;
            padding-bottom: 0.18mm !important;
            padding-right: 0.75mm !important;
            font-size: 5.95pt !important;
            line-height: 1 !important;
        }

        .cert-grid .box-cell {
            width: 7.2mm !important;
            min-width: 7.2mm !important;
            padding-left: 0.15mm !important;
            padding-right: 0.85mm !important;
        }

        /* Yes / No dibuat seperti tabel referensi dan tidak menempel. */
        .yn-wrap {
            padding-left: 1.3mm !important;
        }

        .yn-table td {
            padding-top: 0.13mm !important;
            padding-bottom: 0.13mm !important;
            padding-left: 0.5mm !important;
            padding-right: 0.5mm !important;
            font-size: 6.05pt !important;
        }

        .yn-label {
            min-width: 6.2mm !important;
        }

        /* Note & legend diberi baris sendiri agar tidak saling menimpa. */
        .check-note {
            height: 3.1mm !important;
            padding-top: 0.45mm !important;
            padding-bottom: 0.18mm !important;
            font-size: 6.2pt !important;
            line-height: 1.05 !important;
            vertical-align: bottom !important;
        }

        .check-note-text {
            height: 3.0mm !important;
            padding-top: 0.15mm !important;
            padding-bottom: 0.15mm !important;
            padding-left: 4.4mm !important;
            font-size: 5.95pt !important;
            line-height: 1.05 !important;
            vertical-align: middle !important;
        }

        .legend {
            height: 3.2mm !important;
            padding-top: 0.18mm !important;
            padding-bottom: 0.38mm !important;
            padding-left: 4.4mm !important;
            font-size: 5.95pt !important;
            line-height: 1.05 !important;
            vertical-align: middle !important;
        }

        /* Penutup diberi ukuran yang sama seperti referensi. */
        .thanks {
            margin-top: 1.25mm !important;
            margin-bottom: 2.2mm !important;
            font-size: 7.8pt !important;
            line-height: 1.05 !important;
        }

        .date-block {
            margin-bottom: 1.8mm !important;
            font-size: 7.7pt !important;
            line-height: 1.08 !important;
        }

        /* Signature dibuat lebih besar daripada versi sebelumnya. */
        .signature-table {
            margin-top: 0.6mm !important;
        }

        .sig-heading-left,
        .sig-heading-right {
            height: 5.2mm !important;
            font-size: 7.7pt !important;
        }

        .sig-left-image-area {
            height: 22mm !important;
        }

        .sig-left-image {
            max-width: 24mm !important;
            max-height: 18.5mm !important;
        }

        .right-signatures td {
            height: 22mm !important;
            padding: 0 0.75mm !important;
        }

        .right-signatures img {
            max-width: 24mm !important;
            max-height: 18.5mm !important;
        }

        .sig-left-name-wrap {
            width: 33mm !important;
        }

        .sig-name {
            font-size: 7.2pt !important;
        }

        .sig-role {
            margin-top: 0.35mm !important;
            font-size: 7.0pt !important;
        }

        .right-names {
            margin-top: 0.5mm !important;
            font-size: 6.9pt !important;
        }

        .right-roles {
            margin-top: 0.35mm !important;
            font-size: 6.7pt !important;
        }

        /*
         * Pada hasil sebelumnya footer dipaksa ke paling bawah A4 sehingga
         * tersisa ruang putih sangat besar. Di referensi, footer berada
         * dekat blok signature. Footer digeser naik dan area oranye diteruskan
         * sampai bawah halaman sehingga tidak ada strip putih tambahan.
         */
        .footer {
            bottom: 0 !important;
            height: 20mm !important;
        }

        .footer-info {
            top: 2.3mm !important;
            left: 54mm !important;
            right: 52mm !important;
        }

        .footer-company {
            font-size: 7.0pt !important;
            margin-bottom: 0.45mm !important;
        }

        .footer-text {
            font-size: 5.5pt !important;
            line-height: 1.18 !important;
        }

        .footer-iso {
            right: 5mm !important;
            top: 3.1mm !important;
            width: 35mm !important;
            height: 13mm !important;
        }

        .footer-iso img {
            max-width: 35mm !important;
            max-height: 13mm !important;
        }

        /*
         * Mengisi ruang vertikal dokumen secara natural supaya blok signature
         * turun mendekati footer seperti contoh tanpa menambah ruang kosong
         * setelah signature.
         */
        .mentor-note {
            margin-top: 9.3mm !important;
        }

        .checklist {
            margin-bottom: 0 !important;
        }

        .signature-table {
            margin-bottom: 0 !important;
        }

    
        /* =========================================================
           FINAL MATCH V4 - REQUEST 1..7
        ========================================================= */

        /* 1. Garis tengah hanya pada teks "Penempatan karyawan". */
        .subject-strike {
            text-decoration: line-through !important;
            text-decoration-thickness: 0.25mm !important;
        }

        /* 2. Nilai personel default hitam. Hanya nilai yang ditandai
              highlight-value yang biru, bold, italic. */
        .person-value {
            color: #000000 !important;
            font-weight: normal !important;
            font-style: normal !important;
        }

        .highlight-value {
            color: #123f7a !important;
            font-weight: 700 !important;
            font-style: italic !important;
        }

        /* Rig dan tanggal tetap mengikuti template resmi. */
        .date-strong {
            color: #123f7a !important;
            font-weight: 700 !important;
            font-style: italic !important;
        }

        /* 3. Kolon mentor tidak lagi melompat jauh ke kanan. */
        .mentor-table {
            width: 72mm !important;
            table-layout: fixed !important;
            margin-top: 0 !important;
        }

        .mentor-table .person-label {
            width: 27mm !important;
        }

        .mentor-table .person-colon {
            width: 4mm !important;
            text-align: center !important;
        }

        .mentor-table td:last-child {
            width: 41mm !important;
        }

        /* 4. Hilangkan gap kosong berlebihan sebelum kalimat mentor. */
        .mentor-note {
            margin-top: 3.3mm !important;
            margin-bottom: 1.0mm !important;
            font-size: 8.0pt !important;
            line-height: 1.04 !important;
        }

        /* 5. Kotak V/X dibuat memakai TABLE sungguhan supaya border
              tidak hilang di wkhtmltopdf. */
        .status-box-table {
            display: inline-table !important;
            width: 6.8mm !important;
            height: 5.8mm !important;
            min-width: 6.8mm !important;
            border-collapse: collapse !important;
            border-spacing: 0 !important;
            margin: 0 !important;
            vertical-align: middle !important;
            background: #ffffff !important;
        }

        .status-box-table td {
            width: 6.8mm !important;
            height: 5.8mm !important;
            padding: 0 !important;
            border: 0.28mm solid #000000 !important;
            background: #ffffff !important;
            color: #000000 !important;
            font-family: "Times New Roman", Times, serif !important;
            font-size: 6.2pt !important;
            font-weight: normal !important;
            line-height: 5.3mm !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        /* Nonaktifkan box versi span lama apabila masih tersisa. */
        .status-box {
            display: none !important;
        }

        /* 6. Checklist diperbesar agar proporsinya seperti referensi
              dan area kosong bawah berkurang. */
        .checklist {
            font-size: 6.9pt !important;
            line-height: 1.05 !important;
        }

        .checklist td {
            padding-top: 0.44mm !important;
            padding-bottom: 0.44mm !important;
        }

        .checklist-title {
            height: 5.1mm !important;
            font-size: 7.4pt !important;
        }

        .check-no {
            width: 7.5mm !important;
        }

        .check-name {
            width: 24mm !important;
        }

        .box-cell {
            width: 8mm !important;
            min-width: 8mm !important;
            padding-left: 0.25mm !important;
            padding-right: 0.6mm !important;
        }

        .cert-cell {
            padding-left: 0.8mm !important;
            padding-right: 0 !important;
        }

        .cert-grid {
            width: auto !important;
            table-layout: auto !important;
        }

        .cert-grid td {
            padding-top: 0.22mm !important;
            padding-bottom: 0.22mm !important;
            padding-right: 0.68mm !important;
            font-size: 6.15pt !important;
            line-height: 1.02 !important;
        }

        .cert-grid .box-cell {
            width: 7.9mm !important;
            min-width: 7.9mm !important;
            padding-left: 0.15mm !important;
            padding-right: 0.75mm !important;
        }

        .yn-wrap {
            padding-left: 1.2mm !important;
        }

        .yn-table td {
            padding-top: 0.15mm !important;
            padding-bottom: 0.15mm !important;
            padding-left: 0.45mm !important;
            padding-right: 0.45mm !important;
            font-size: 6.2pt !important;
        }

        .yn-table .box-cell {
            width: 7.8mm !important;
            min-width: 7.8mm !important;
        }

        .yn-label {
            min-width: 5.8mm !important;
        }

        .check-note {
            height: 3.2mm !important;
            padding-top: 0.45mm !important;
            padding-bottom: 0.15mm !important;
            font-size: 6.25pt !important;
        }

        .check-note-text {
            height: 3.0mm !important;
            padding-top: 0.1mm !important;
            padding-bottom: 0.1mm !important;
            padding-left: 4.2mm !important;
            font-size: 5.95pt !important;
        }

        .legend {
            height: 3.2mm !important;
            padding-top: 0.12mm !important;
            padding-bottom: 0.35mm !important;
            padding-left: 4.2mm !important;
            font-size: 5.95pt !important;
        }

        /* Area penutup dan tanda tangan dibuat lebih besar sehingga
           komposisi halaman tidak meninggalkan placeholder putih besar. */
        .thanks {
            margin-top: 1.2mm !important;
            margin-bottom: 2.4mm !important;
            font-size: 8.1pt !important;
        }

        .date-block {
            margin-bottom: 2.2mm !important;
            font-size: 8.0pt !important;
        }

        .signature-table {
            margin-top: 1.2mm !important;
            font-size: 8.0pt !important;
        }

        .sig-heading-left,
        .sig-heading-right {
            height: 5.5mm !important;
        }

        .sig-left-image-area {
            height: 23mm !important;
        }

        .sig-left-image {
            max-width: 26mm !important;
            max-height: 20mm !important;
        }

        .right-signatures td {
            height: 23mm !important;
        }

        .right-signatures img {
            max-width: 26mm !important;
            max-height: 20mm !important;
        }

        .sig-left-name-wrap {
            width: 34mm !important;
        }

        .sig-name {
            color: #123f7a !important;
            font-size: 7.4pt !important;
        }

        .sig-role {
            color: #123f7a !important;
            font-size: 7.1pt !important;
        }

        .right-names {
            color: #123f7a !important;
            font-size: 7.0pt !important;
        }

        .right-roles {
            color: #123f7a !important;
            font-size: 6.8pt !important;
        }

        /* 7. Footer disamakan lagi: oranye template, full sampai bawah,
              informasi alamat lengkap, ISO tetap kecil di kanan. */
        .footer {
            bottom: 0 !important;
            height: 22mm !important;
            background: #f7941d !important;
            color: #ffffff !important;
            overflow: hidden !important;
        }

        .footer-info {
            left: 0 !important;
            right: 43mm !important;
            top: 2.0mm !important;
            width: auto !important;
            text-align: center !important;
        }

        .footer-company {
            margin-bottom: 0.45mm !important;
            font-size: 7.3pt !important;
            font-weight: 700 !important;
            line-height: 1.1 !important;
        }

        .footer-text {
            font-size: 5.8pt !important;
            line-height: 1.23 !important;
            white-space: normal !important;
        }

        .footer-iso {
            right: 4.5mm !important;
            top: 3mm !important;
            width: 36mm !important;
            height: 14mm !important;
        }

        .footer-iso img {
            display: block !important;
            width: auto !important;
            height: auto !important;
            max-width: 36mm !important;
            max-height: 14mm !important;
            margin: 0 0 0 auto !important;
            object-fit: contain !important;
        }

        /* Sediakan ruang footer, tetapi jangan berlebihan. */
        .page {
            padding-bottom: 22mm !important;
        }

    
        /* =========================================================
           FINAL MATCH V5
           - checkbox persegi panjang
           - hapus K3 paling depan di matrix sertifikat
           - SWP turun ke baris berikutnya
           - ukuran isi diperbesar agar halaman lebih penuh
           - footer orange + alamat benar-benar di tengah
        ========================================================= */

        body {
            font-size: 10pt !important;
            line-height: 1.1 !important;
        }

        .page {
            padding: 5.2mm 8mm 22mm 8mm !important;
        }

        .header-table {
            font-size: 7.15pt !important;
            margin-bottom: 3.6mm !important;
        }

        .header-table td {
            padding-top: 0.55mm !important;
            padding-bottom: 0.55mm !important;
        }

        .doc-number {
            font-size: 7.35pt !important;
        }

        .csms {
            font-size: 8.1pt !important;
        }

        .form-name {
            font-size: 8pt !important;
        }

        .form-no {
            font-size: 7.55pt !important;
        }

        .small-head,
        .small-value {
            font-size: 6.15pt !important;
        }

        .address {
            font-size: 9.15pt !important;
            margin-bottom: 2.5mm !important;
        }

        .subject {
            font-size: 9.3pt !important;
            margin-bottom: 1mm !important;
        }

        .person-intro {
            font-size: 9pt !important;
            margin-bottom: 0.6mm !important;
        }

        .person-table {
            font-size: 9.15pt !important;
            line-height: 1.05 !important;
        }

        .person-table td {
            padding-top: 0.2mm !important;
            padding-bottom: 0.2mm !important;
        }

        .mentor-title {
            font-size: 8.9pt !important;
        }

        .mentor-note {
            margin-top: 4.2mm !important;
            margin-bottom: 1.2mm !important;
            font-size: 8.45pt !important;
        }

        /* =========================================================
           CHECKLIST: dibuat lebih besar & lebih tinggi
        ========================================================= */
        .checklist {
            font-size: 7.35pt !important;
            line-height: 1.06 !important;
        }

        .checklist-title {
            height: 5.5mm !important;
            font-size: 7.85pt !important;
        }

        .checklist td {
            padding-top: 0.5mm !important;
            padding-bottom: 0.5mm !important;
        }

        .check-no {
            width: 7.8mm !important;
        }

        .check-name {
            width: 25.5mm !important;
            line-height: 1.08 !important;
        }

        /* Kotak V/X dibuat PERSEGI PANJANG, tidak terlalu tinggi,
           sehingga antar baris tidak saling menempel. */
        .status-box-table {
            width: 8.2mm !important;
            min-width: 8.2mm !important;
            height: 4.8mm !important;
            min-height: 4.8mm !important;
        }

        .status-box-table td {
            width: 8.2mm !important;
            height: 4.8mm !important;
            min-height: 4.8mm !important;
            line-height: 4.35mm !important;
            border: 0.28mm solid #000000 !important;
            font-size: 6.35pt !important;
        }

        .box-cell {
            width: 9.3mm !important;
            min-width: 9.3mm !important;
            padding-left: 0.2mm !important;
            padding-right: 0.9mm !important;
        }

        .cert-grid {
            width: auto !important;
            table-layout: auto !important;
        }

        .cert-grid td {
            padding-top: 0.3mm !important;
            padding-bottom: 0.3mm !important;
            padding-right: 0.9mm !important;
            font-size: 6.45pt !important;
            line-height: 1.02 !important;
        }

        .cert-grid .box-cell {
            width: 9.1mm !important;
            min-width: 9.1mm !important;
            padding-right: 0.95mm !important;
        }

        .yn-table td {
            font-size: 6.45pt !important;
            padding-top: 0.2mm !important;
            padding-bottom: 0.2mm !important;
        }

        .yn-table .box-cell {
            width: 9mm !important;
            min-width: 9mm !important;
        }

        .yn-label {
            min-width: 6.2mm !important;
        }

        .check-note {
            height: 3.6mm !important;
            font-size: 6.55pt !important;
        }

        .check-note-text,
        .legend {
            font-size: 6.2pt !important;
            line-height: 1.06 !important;
        }

        .check-note-text {
            height: 3.25mm !important;
        }

        .legend {
            height: 3.45mm !important;
        }

        /* =========================================================
           PENUTUP & SIGNATURE: diperbesar untuk mengisi halaman
        ========================================================= */
        .thanks {
            margin-top: 1.6mm !important;
            margin-bottom: 2.8mm !important;
            font-size: 8.7pt !important;
        }

        .date-block {
            margin-bottom: 2.6mm !important;
            font-size: 8.55pt !important;
            line-height: 1.08 !important;
        }

        .signature-table {
            margin-top: 1.6mm !important;
            font-size: 8.45pt !important;
        }

        .sig-heading-left,
        .sig-heading-right {
            height: 6mm !important;
            font-size: 8.35pt !important;
        }

        .sig-left-image-area,
        .right-signatures td {
            height: 28mm !important;
        }

        .sig-left-image,
        .right-signatures img {
            max-width: 29mm !important;
            max-height: 23mm !important;
        }

        .sig-left-name-wrap {
            width: 36mm !important;
        }

        .sig-name {
            font-size: 7.8pt !important;
        }

        .sig-role {
            font-size: 7.5pt !important;
            margin-top: 0.4mm !important;
        }

        .right-names {
            font-size: 7.4pt !important;
            margin-top: 0.55mm !important;
        }

        .right-roles {
            font-size: 7.15pt !important;
            margin-top: 0.4mm !important;
        }

        /* =========================================================
           FOOTER
           Warna dibuat lebih dekat ke contoh dan alamat dipusatkan
           terhadap SELURUH lebar halaman, bukan area kiri saja.
        ========================================================= */
        .footer {
            height: 22mm !important;
            background: #f58220 !important;
            color: #ffffff !important;
        }

        .footer-info {
            left: 0 !important;
            right: 0 !important;
            top: 2.05mm !important;
            width: 100% !important;
            padding: 0 42mm !important;
            text-align: center !important;
        }

        .footer-company {
            font-size: 7.45pt !important;
            line-height: 1.1 !important;
            margin-bottom: 0.45mm !important;
        }

        .footer-text {
            font-size: 5.95pt !important;
            line-height: 1.25 !important;
            text-align: center !important;
        }

        .footer-iso {
            right: 4mm !important;
            top: 3mm !important;
            width: 36mm !important;
            height: 14mm !important;
        }

        .footer-iso img {
            max-width: 36mm !important;
            max-height: 14mm !important;
        }

    
        /* =========================================================
           FINAL MATCH V6
           - Baris sertifikat kedua: checkbox dulu baru label
           - Hanya "Legend :" bold
           - Semua font dibesarkan
           - Signature diperbesar
           - Halaman lebih penuh
           - Footer matte orange
        ========================================================= */

        body {
            font-size: 10.35pt !important;
            line-height: 1.12 !important;
        }

        .page {
            padding: 5mm 7.5mm 22mm 7.5mm !important;
        }

        .header-table {
            font-size: 7.55pt !important;
            margin-bottom: 3.8mm !important;
        }

        .header-table td {
            padding-top: 0.65mm !important;
            padding-bottom: 0.65mm !important;
        }

        .doc-number {
            font-size: 7.8pt !important;
        }

        .csms {
            font-size: 8.55pt !important;
        }

        .form-name {
            font-size: 8.4pt !important;
        }

        .form-no {
            font-size: 7.95pt !important;
        }

        .small-head,
        .small-value {
            font-size: 6.55pt !important;
        }

        .address {
            font-size: 9.55pt !important;
            line-height: 1.1 !important;
            margin-bottom: 2.8mm !important;
        }

        .subject {
            font-size: 9.75pt !important;
            margin-bottom: 1.15mm !important;
        }

        .person-intro {
            font-size: 9.45pt !important;
        }

        .person-table {
            font-size: 9.55pt !important;
            line-height: 1.06 !important;
        }

        .person-table td {
            padding-top: 0.24mm !important;
            padding-bottom: 0.24mm !important;
        }

        .mentor-title {
            font-size: 9.25pt !important;
        }

        .mentor-note {
            margin-top: 4.5mm !important;
            margin-bottom: 1.35mm !important;
            font-size: 8.75pt !important;
        }

        /* =========================
           CHECKLIST
        ========================== */
        .checklist {
            font-size: 7.75pt !important;
            line-height: 1.08 !important;
        }

        .checklist-title {
            height: 5.8mm !important;
            font-size: 8.15pt !important;
        }

        .checklist td {
            padding-top: 0.56mm !important;
            padding-bottom: 0.56mm !important;
        }

        .check-no {
            width: 8mm !important;
        }

        .check-name {
            width: 26mm !important;
        }

        .status-box-table {
            width: 8.7mm !important;
            min-width: 8.7mm !important;
            height: 5.0mm !important;
            min-height: 5.0mm !important;
        }

        .status-box-table td {
            width: 8.7mm !important;
            height: 5.0mm !important;
            min-height: 5.0mm !important;
            line-height: 4.55mm !important;
            font-size: 6.65pt !important;
        }

        .box-cell {
            width: 9.8mm !important;
            min-width: 9.8mm !important;
            padding-left: 0.22mm !important;
            padding-right: 0.85mm !important;
        }

        .cert-grid {
            width: auto !important;
            table-layout: auto !important;
        }

        .cert-grid td {
            padding-top: 0.34mm !important;
            padding-bottom: 0.34mm !important;
            padding-right: 0.8mm !important;
            font-size: 6.75pt !important;
            line-height: 1.04 !important;
        }

        .cert-grid .box-cell {
            width: 9.5mm !important;
            min-width: 9.5mm !important;
            padding-right: 0.75mm !important;
        }

        /* Baris kedua khusus: box dulu lalu label */
        .cert-row-box-first .box-cell {
            padding-right: 0.35mm !important;
        }

        .cert-row-box-first .cert-label {
            padding-right: 1.05mm !important;
        }

        .yn-table td {
            font-size: 6.75pt !important;
            padding-top: 0.22mm !important;
            padding-bottom: 0.22mm !important;
        }

        .yn-label {
            min-width: 6.5mm !important;
        }

        .check-note {
            height: 3.8mm !important;
            font-size: 6.85pt !important;
        }

        .check-note-text {
            height: 3.45mm !important;
            font-size: 6.5pt !important;
        }

        .legend {
            height: 3.65mm !important;
            font-size: 6.5pt !important;
            font-weight: normal !important;
        }

        .legend strong {
            font-weight: 700 !important;
        }

        .legend span {
            font-weight: normal !important;
        }

        /* =========================
           CLOSING + SIGNATURE
        ========================== */
        .thanks {
            margin-top: 1.9mm !important;
            margin-bottom: 3.1mm !important;
            font-size: 9.05pt !important;
        }

        .date-block {
            margin-bottom: 3.1mm !important;
            font-size: 8.95pt !important;
            line-height: 1.1 !important;
        }

        .signature-table {
            margin-top: 2.0mm !important;
            font-size: 8.9pt !important;
        }

        .sig-heading-left,
        .sig-heading-right {
            height: 6.7mm !important;
            font-size: 8.8pt !important;
        }

        .sig-left-image-area,
        .right-signatures td {
            height: 33mm !important;
        }

        .sig-left-image,
        .right-signatures img {
            max-width: 34mm !important;
            max-height: 27mm !important;
        }

        .sig-left-name-wrap {
            width: 39mm !important;
        }

        .sig-name {
            font-size: 8.45pt !important;
        }

        .sig-role {
            font-size: 8.05pt !important;
            margin-top: 0.45mm !important;
        }

        .right-names {
            font-size: 7.95pt !important;
            margin-top: 0.65mm !important;
        }

        .right-roles {
            font-size: 7.65pt !important;
            margin-top: 0.45mm !important;
        }

        /* =========================
           MATTE ORANGE FOOTER
        ========================== */
        .footer {
            height: 22mm !important;
            background: #e98224 !important;
            color: #ffffff !important;
        }

        .footer-info {
            left: 0 !important;
            right: 0 !important;
            top: 2.1mm !important;
            width: 100% !important;
            padding: 0 41mm !important;
            text-align: center !important;
        }

        .footer-company {
            font-size: 7.75pt !important;
            line-height: 1.08 !important;
            margin-bottom: 0.5mm !important;
        }

        .footer-text {
            font-size: 6.15pt !important;
            line-height: 1.25 !important;
            text-align: center !important;
        }

        .footer-iso {
            right: 4mm !important;
            top: 3.0mm !important;
            width: 37mm !important;
            height: 14.5mm !important;
        }

        .footer-iso img {
            max-width: 37mm !important;
            max-height: 14.5mm !important;
        }

    
        /* =========================================================
           FINAL MATCH V7
           1. Nama/Jabatan pertama hitam + bold
           2. Checkbox K3/SIM/APB/JB/OLB/OMB sejajar
           3. Nama/Jabatan signature diperbesar, gambar signature diperkecil
        ========================================================= */

        .black-bold-value {
            color: #000000 !important;
            font-weight: 700 !important;
            font-style: normal !important;
        }

        /* Matrix sertifikat: setiap pasangan box/label punya lebar tetap,
           sehingga checkbox baris kedua sejajar dengan checkbox baris atas. */
        .cert-grid {
            table-layout: fixed !important;
        }

        .cert-grid .box-cell {
            width: 9.4mm !important;
            min-width: 9.4mm !important;
            max-width: 9.4mm !important;
            padding-left: 0 !important;
            padding-right: 0.7mm !important;
            text-align: left !important;
        }

        .cert-grid .cert-label {
            width: 8.2mm !important;
            min-width: 8.2mm !important;
            max-width: 8.2mm !important;
            padding-left: 0 !important;
            padding-right: 0.8mm !important;
            text-align: left !important;
        }

        .cert-row-box-first .box-cell,
        .cert-row-box-first .cert-label {
            vertical-align: middle !important;
        }

        .status-box-table {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* Signature image lebih kecil dan proporsional. */
        .sig-left-image,
        .right-signatures img {
            max-width: 23mm !important;
            max-height: 17mm !important;
        }

        .sig-left-image-area,
        .right-signatures td {
            height: 25mm !important;
        }

        /* Nama + jabatan signature diperbesar. */
        .sig-name {
            font-size: 9.2pt !important;
            line-height: 1.08 !important;
        }

        .sig-role {
            font-size: 8.7pt !important;
            line-height: 1.08 !important;
            margin-top: 0.55mm !important;
        }

        .right-names {
            font-size: 8.9pt !important;
            line-height: 1.08 !important;
            margin-top: 0.8mm !important;
        }

        .right-roles {
            font-size: 8.4pt !important;
            line-height: 1.08 !important;
            margin-top: 0.55mm !important;
        }

    
        /* =========================================================
           FINAL MATCH V8
           1. Checkbox sertifikat sejajar + jarak Disnaker
           2. Nama/jabatan signature lebih besar, signature tepat di atas nama
           3. Font alamat footer lebih besar dan tetap center
        ========================================================= */

        /* ---- CERTIFICATE MATRIX ALIGNMENT ---- */
        .cert-grid {
            table-layout: fixed !important;
        }

        .cert-grid .cert-label {
            width: 8.2mm !important;
            min-width: 8.2mm !important;
            max-width: 8.2mm !important;
        }

        .cert-grid .box-cell {
            width: 9.4mm !important;
            min-width: 9.4mm !important;
            max-width: 9.4mm !important;
        }

        .cert-empty-label {
            width: 8.2mm !important;
            min-width: 8.2mm !important;
            max-width: 8.2mm !important;
            padding: 0 !important;
        }

        .cert-row-box-first .box-cell {
            padding-left: 0 !important;
            padding-right: 0.7mm !important;
        }

        .cert-row-box-first .cert-label {
            padding-left: 0 !important;
            padding-right: 0.8mm !important;
        }

        /* Beri napas khusus antara tulisan Disnaker dan checkbox pertama. */
        .cert-disnaker-label {
            padding-right: 1.8mm !important;
        }

        .cert-disnaker-box {
            padding-left: 1.2mm !important;
        }

        /* ---- SIGNATURE POSITION / SIZE ---- */
        .signature-table {
            table-layout: fixed !important;
        }

        .sig-left-image-area {
            text-align: center !important;
        }

        .sig-left-image {
            display: block !important;
            max-width: 20mm !important;
            max-height: 14.5mm !important;
            margin: 0 auto 0.8mm auto !important;
        }

        .sig-left-name-wrap {
            width: 100% !important;
            text-align: center !important;
        }

        .right-signatures {
            width: 100% !important;
            table-layout: fixed !important;
        }

        .right-signatures td {
            height: 22mm !important;
            vertical-align: bottom !important;
            text-align: center !important;
            padding: 0 0.4mm !important;
        }

        .right-signatures img {
            display: block !important;
            max-width: 20mm !important;
            max-height: 14.5mm !important;
            margin: 0 auto 0.8mm auto !important;
        }

        /* Nama & jabatan dibuat lebih besar dan lebih dominan. */
        .sig-name {
            font-size: 10.4pt !important;
            line-height: 1.05 !important;
            text-align: center !important;
        }

        .sig-role {
            font-size: 9.6pt !important;
            line-height: 1.05 !important;
            margin-top: 0.65mm !important;
            text-align: center !important;
        }

        .right-names {
            font-size: 10.1pt !important;
            line-height: 1.05 !important;
            margin-top: 0.9mm !important;
            text-align: center !important;
        }

        .right-roles {
            font-size: 9.35pt !important;
            line-height: 1.05 !important;
            margin-top: 0.65mm !important;
            text-align: center !important;
        }

        /* ---- FOOTER ADDRESS ---- */
        .footer-info {
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            padding: 0 42mm !important;
            text-align: center !important;
        }

        .footer-company {
            font-size: 8.55pt !important;
            line-height: 1.08 !important;
            text-align: center !important;
        }

        .footer-text {
            font-size: 6.9pt !important;
            line-height: 1.28 !important;
            text-align: center !important;
        }

    </style>
</head>

<body>
<div class="page">

    <table class="header-table">
        <tr>
            <td class="header-left doc-number">
                Dokumen Number<br>
                API-HRD-016/PRO
            </td>

            <td class="header-center csms">
                Company Safety Management System (CSMS)
            </td>

            <td class="header-logo" rowspan="3">
                @if(!empty($data['logo_data']))
                    <img src="{{ $data['logo_data'] }}" alt="ARJUNA">
                @endif
            </td>
        </tr>

        <tr>
            <td class="header-left">
                <strong><em>Form Name</em></strong>
            </td>

            <td class="header-center form-name">
                Surat Tugas
            </td>
        </tr>

        <tr>
            <td class="header-left">
                <strong><em>Form No</em></strong>
            </td>

            <td class="header-center form-no">
                API-HRD-016.001/FORM
            </td>
        </tr>

        <tr>
            <td style="padding:0;">
                <table style="width:100%; table-layout:fixed;">
                    <tr>
                        <td style="border:0; border-right:0.25mm solid #000; width:48%; font-weight:bold; font-style:italic;">
                            Document<br>Level
                        </td>
                        <td style="border:0; text-align:center; width:52%; font-weight:bold;">
                            3
                        </td>
                    </tr>
                </table>
            </td>

            <td style="padding:0;">
                <table style="width:100%; table-layout:fixed;">
                    <tr>
                        <td class="small-head" style="border:0; border-right:0.25mm solid #000;">
                            Issue Date
                        </td>
                        <td class="small-head" style="border:0; border-right:0.25mm solid #000;">
                            Rev. Date
                        </td>
                        <td class="small-head" style="border:0;">
                            Rev. No
                        </td>
                    </tr>
                    <tr>
                        <td class="small-value" style="border:0; border-top:0.25mm solid #000; border-right:0.25mm solid #000;">
                            20-Okt-2020
                        </td>
                        <td class="small-value" style="border:0; border-top:0.25mm solid #000; border-right:0.25mm solid #000;">
                            01-Okt-2022
                        </td>
                        <td class="small-value" style="border:0; border-top:0.25mm solid #000;">
                            01
                        </td>
                    </tr>
                </table>
            </td>

            <td style="padding:0;">
                <table style="width:100%; table-layout:fixed;">
                    <tr>
                        <td colspan="2" class="small-head" style="border:0; border-bottom:0.25mm solid #000;">
                            Approved by
                        </td>
                    </tr>
                    <tr>
                        <td class="small-value" style="border:0; border-right:0.25mm solid #000;">
                            HRD
                        </td>
                        <td class="small-value" style="border:0;">
                            GM
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <div class="body">

        <div class="address">
            <p>Kepada Yth,</p>
            <p>Bapak/Ibuk Drilling / Workover Site Manager &amp; Tool Pusher</p>
            <p>Rig API # <span style="color:#123f7a; font-weight:bold; font-style:italic;">{{ $data['rig'] }}</span></p>
            <p>Di – Rig Site</p>
        </div>


        <p class="subject">
            <strong>Perihal</strong>
            :&nbsp;&nbsp;<b><span class="subject-strike">Penempatan karyawan</span> / Surat tugas</b>
        </p>

        <p class="person-intro">
            Sehubungan dengan ( {{ $data['status'] }} ) saudara :
        </p>


        <table class="person-table">
            <tr>
                <td class="person-label">Nama</td>
                <td class="person-colon">:</td>
                <td class="person-value black-bold-value">{{ $data['old_name'] }}</td>
            </tr>

            <tr>
                <td class="person-label">Jabatan</td>
                <td class="person-colon">:</td>
                <td class="person-value black-bold-value">{{ $data['old_job'] }}</td>
            </tr>

            <tr>
                <td class="person-label">Alasan</td>
                <td class="person-colon">:</td>
                <td class="person-value highlight-value">{{ $data['reason'] }}</td>
            </tr>

            <tr>
                <td colspan="3" class="replace-line">
                    Untuk sementara t.m.t
                    <span class="person-value highlight-value">{{ $data['period'] }}</span>
                    di ganti oleh :
                </td>
            </tr>

            <tr>
                <td class="person-label">Nama</td>
                <td class="person-colon">:</td>
                <td class="person-value highlight-value">{{ $data['new_name'] }}</td>
            </tr>

            <tr>
                <td class="person-label">Jabatan</td>
                <td class="person-colon">:</td>
                <td class="person-value highlight-value">{{ $data['new_job'] }}</td>
            </tr>
        </table>


        <p class="mentor-title">
            Dan akan di Mentor oleh (Jika SSE),
        </p>

        <table class="person-table mentor-table" style="margin-bottom:0;">
            <tr>
                <td class="person-label">Nama</td>
                <td class="person-colon">:</td>
                <td class="person-value">{{ $data['mentor_name'] }}</td>
            </tr>

            <tr>
                <td class="person-label">Jabatan</td>
                <td class="person-colon">:</td>
                <td class="person-value">{{ $data['mentor_job'] }}</td>
            </tr>
        </table>


        <p class="mentor-note">
            Tugas dan tangung jawab Mentor silahkan dilihat PT. API SSE procedure No. API-HRD-016.SPS - SSE
        </p>


        <table class="checklist">
            <colgroup>
                <col style="width:8mm;">
                <col style="width:26mm;">
                <col style="width:9mm;">
                <col>
            </colgroup>

            <tr>
                <td colspan="4" class="checklist-title">
                    Checklist kelengkapan dokumen karyawan
                </td>
            </tr>

            <tr>
                <td class="check-no">1.</td>
                <td class="check-name">Badge</td>
                <td class="box-cell">
                    <table class="status-box-table"><tr><td>{{ $data['badge'] }}</td></tr></table>
                </td>
                <td></td>
            </tr>

            <tr>
                <td class="check-no">2.</td>
                <td class="check-name">Sertifikat</td>
                <td colspan="2" class="cert-cell">
                    <table class="cert-grid">
                        <tr>
                            <td class="cert-label">Migas</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['migas'] }}</td></tr></table></td>

                            <td class="cert-label">IADC</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['iadc'] }}</td></tr></table></td>

                            <td class="cert-label">APPS</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['apps'] }}</td></tr></table></td>

                            <td class="cert-label">OUPS</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['oups'] }}</td></tr></table></td>

                            <td class="cert-label">OMPS</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['omps'] }}</td></tr></table></td>

                            <td class="cert-label">OLPS</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['olps'] }}</td></tr></table></td>

                            <td class="cert-label">TKBT</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['tkbt'] }}</td></tr></table></td>

                            <td class="cert-label">LOP</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['lop'] }}</td></tr></table></td>
                        </tr>

                        <tr class="cert-row-box-first">
                            <td class="cert-label cert-empty-label"></td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['k3'] ?? '' }}</td></tr></table></td>
                            <td class="cert-label">K3</td>

                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['sim'] }}</td></tr></table></td>
                            <td class="cert-label">SIM</td>

                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['apb'] }}</td></tr></table></td>
                            <td class="cert-label">APB</td>

                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['jb'] }}</td></tr></table></td>
                            <td class="cert-label">JB</td>

                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['olb'] }}</td></tr></table></td>
                            <td class="cert-label">OLB</td>

                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['omb'] }}</td></tr></table></td>
                            <td class="cert-label">OMB</td>

                            <td colspan="4"></td>
                        </tr>

                        <tr>
                            <td class="cert-label cert-disnaker-label">Disnaker</td>
                            <td class="box-cell cert-disnaker-box"><table class="status-box-table"><tr><td>{{ $data['disnaker'] }}</td></tr></table></td>

                            <td class="cert-label">K3</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['k3_disnaker'] }}</td></tr></table></td>

                            <td class="cert-label">Rigger</td>
                            <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['rigger'] }}</td></tr></table></td>

                            <td colspan="10">Lain - lain : {{ $data['other_certificate'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="check-no">3.</td>
                <td class="check-name">MCU</td>
                <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['mcu'] }}</td></tr></table></td>
                <td></td>
            </tr>

            <tr>
                <td class="check-no">4.</td>
                <td class="check-name">KTP</td>
                <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['kp'] }}</td></tr></table></td>
                <td></td>
            </tr>

            <tr>
                <td class="check-no">5.</td>
                <td class="check-name">MCU</td>
                <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['mcu_vaccine'] }}</td></tr></table></td>
                <td></td>
            </tr>

            <tr>
                <td class="check-no">6.</td>
                <td class="check-name">Self Declaration</td>
                <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['self_declaration'] }}</td></tr></table></td>
                <td></td>
            </tr>

            <tr>
                <td class="check-no">7.</td>
                <td class="check-name">SSE</td>
                <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['sse_status'] }}</td></tr></table></td>
                <td class="yn-wrap">
                    <table class="yn-table">
                        <tr>
                            <td class="yn-label">Yes</td>
                            <td class="box-cell">
                                <table class="status-box-table"><tr><td>{{ $data['sse_yes_no'] === 'Yes' ? 'V' : ($data['sse_yes_no'] === 'No' ? 'X' : '') }}</td></tr></table>
                            </td>
                            <td class="yn-label">No</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="check-no">8.</td>
                <td class="check-name">APD Mandatory</td>
                <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['apd_status'] }}</td></tr></table></td>
                <td class="yn-wrap">
                    <table class="yn-table">
                        <tr>
                            <td class="yn-label">Yes</td>
                            <td class="box-cell">
                                <table class="status-box-table"><tr><td>{{ $data['apd_yes_no'] === 'Yes' ? 'V' : ($data['apd_yes_no'] === 'No' ? 'X' : '') }}</td></tr></table>
                            </td>
                            <td class="yn-label">No</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="check-no">9.</td>
                <td class="check-name">Training Mandatory<br>SWP</td>
                <td class="box-cell"><table class="status-box-table"><tr><td>{{ $data['training_status'] }}</td></tr></table></td>
                <td class="yn-wrap">
                    <table class="yn-table">
                        <tr>
                            <td class="yn-label">Yes</td>
                            <td class="box-cell">
                                <table class="status-box-table"><tr><td>{{ $data['training_yes_no'] === 'Yes' ? 'V' : ($data['training_yes_no'] === 'No' ? 'X' : '') }}</td></tr></table>
                            </td>
                            <td class="yn-label">No</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="4" class="check-note">Note :</td>
            </tr>

            <tr>
                <td colspan="4" class="check-note-text">
                    Semua dokumen karyawan dilampirkan bersama surat tugas
                </td>
            </tr>

            <tr>
                <td colspan="4" class="legend">
                    <strong>Legend :</strong>
                    <span>(V) Ada&nbsp;&nbsp; (X) Tidak Ada&nbsp;&nbsp; (T/P) Tidak Diperlukan</span>
                </td>
            </tr>
        </table>


        <p class="thanks">
            Demikianlah di sampaikan,atas perhatiannya kami ucapkan terima kasih
        </p>


        <div class="date-block">
            <div>
                Duri <span class="date-strong">{{ $data['document_date'] }} {{ $data['document_year'] }}</span>
            </div>
            <div>PT. Arjuna Petrogas Indonesia</div>
        </div>


        <table class="signature-table">
            <tr>
                <td class="sig-left sig-heading-left">
                    Dibuat Oleh,
                </td>

                <td class="sig-right sig-heading-right">
                    Diperiksa &amp; Disetujui Oleh,
                </td>
            </tr>

            <tr>
                <td class="sig-left sig-left-image-area">
                    @if(!empty($data['signature_fc']))
                        <img
                            class="sig-left-image"
                            src="{{ $data['signature_fc'] }}"
                            alt=""
                        >
                    @endif
                </td>

                <td class="sig-right">
                    <table class="right-signatures">
                        <tr>
                            <td>
                                @if(!empty($data['signature_tp']))
                                    <img src="{{ $data['signature_tp'] }}" alt="">
                                @endif
                            </td>

                            <td>
                                @if(!empty($data['signature_rs']))
                                    <img src="{{ $data['signature_rs'] }}" alt="">
                                @endif
                            </td>

                            <td>
                                @if(!empty($data['signature_am']))
                                    <img src="{{ $data['signature_am'] }}" alt="">
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="sig-left">
                    <div class="sig-left-name-wrap">
                        <div class="sig-name">{{ $data['name_fc'] }}</div>
                        <div class="sig-role">Field Coord.</div>
                    </div>
                </td>

                <td class="sig-right">
                    <div class="right-names">
                        {{ $data['name_tp'] }} / {{ $data['name_rs'] }} / {{ $data['name_am'] }}
                    </div>

                    <div class="right-roles">
                        Toolpusher / Rig Supt / Area Manager
                    </div>
                </td>
            </tr>
        </table>

    </div>

    <div class="footer">
        <div class="footer-info">
            <div class="footer-company">PT ARJUNA PETROGAS INDONESIA</div>
            <div class="footer-text">
                Treasury Tower 2nd Floor, District 8 - SCBD Lot 28<br>
                Jl. Jend. Sudirman Kav. 52-53 Jakarta 12190<br>
                Phone. (021) 50102888 Fax. (021) 50107888
            </div>
        </div>

        <div class="footer-iso">
            @if(!empty($data['iso_data']))
                <img src="{!! $data['iso_data'] !!}" alt="ISO">
            @endif
        </div>
    </div>
</div>
</body>
</html>
