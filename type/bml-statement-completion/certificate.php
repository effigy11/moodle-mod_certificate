<?php

// This file is part of the Certificate module for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * A4_embedded certificate type
 *
 * @package    mod
 * @subpackage certificate
 * @copyright  Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from view.php
}

$pdf = new TCPDF($certificate->orientation, 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetTitle($certificate->name);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false, 0);
$pdf->AddPage();

// Define variables
// Landscape
if ($certificate->orientation == 'L') {
    $x = 20;
    $y = 50;
    $sealx = 230;
    $sealy = 150;
    $sigx = 47;
    $sigy = 155;
    $custx = 47;
    $custy = 155;
    $wmarkx = 40;
    $wmarky = 31;
    $wmarkw = 212;
    $wmarkh = 148;
    $brdrx = 0;
    $brdry = 0;
    $brdrw = 297;
    $brdrh = 210;
    $codey = 175;
} else { //Portrait
    $x = 10;
    $y = 40;
    $sealx = 150;
    $sealy = 220;
    $sigx = 30;
    $sigy = 230;
    $custx = 30;
    $custy = 230;
    $wmarkx = 26;
    $wmarky = 58;
    $wmarkw = 158;
    $wmarkh = 170;
    $brdrx = 0;
    $brdry = 0;
    $brdrw = 210;
    $brdrh = 297;
    $codey = 250;
}

// Add images and lines
certificate_print_image($pdf, $certificate, CERT_IMAGE_BORDER, $brdrx, $brdry, $brdrw, $brdrh);
certificate_draw_frame($pdf, $certificate);
// Set alpha to semi-transparency
$pdf->SetAlpha(0.2);
certificate_print_image($pdf, $certificate, CERT_IMAGE_WATERMARK, $wmarkx, $wmarky, $wmarkw, $wmarkh);
$pdf->SetAlpha(1);
certificate_print_image($pdf, $certificate, CERT_IMAGE_SEAL, $sealx, $sealy, '', '');
certificate_print_image($pdf, $certificate, CERT_IMAGE_SIGNATURE, $sigx, $sigy, '', '');


// Add text
$pdf->SetTextColor(255, 255, 255);
//certificate_print_text($pdf, $x, $y, 'C', 'Helvetica', '', 30, get_string('title', 'certificate'));

// ADDS COURSE TITLE AT TOP OF DOCUMENT
if ($course->fullname == 'Induction - Forklift Operator') {
    certificate_print_text($pdf, $x + 18, $y, 'L', 'Helvetica', '', 30, 'Forklift Operator Induction');
}
if ($course->fullname == 'Induction - Tenant Employee') {
    certificate_print_text($pdf, $x + 18, $y, 'L', 'Helvetica', '', 30, 'Tenant Employee Induction');
}
if ($course->fullname == 'Induction - Buyer') {
    certificate_print_text($pdf, $x + 18, $y, 'L', 'Helvetica', '', 30, 'Buyer Induction');
}
if ($course->fullname == 'Induction - Contractor') {
    certificate_print_text($pdf, $x + 18, $y, 'L', 'Helvetica', '', 30, 'Contractor Induction');
}
if ($course->fullname == 'Induction - Tenant Principal') {
    certificate_print_text($pdf, $x + 18, $y, 'L', 'Helvetica', '', 30, 'Tenant Principal Induction');
}
//certificate_print_text($pdf, $x, $y + 72, 'C', 'Helvetica', '', 20, $course->fullname);
$pdf->SetTextColor(0, 0, 0);
//certificate_print_text($pdf, $x, $y + 20, 'C', 'Helvetica', '', 20, get_string('certify', 'certificate'));
certificate_print_text($pdf, $x + 23, $y + 35, 'L', 'Helvetica', '', 19, strtoupper(fullname($USER)));

// ADDS COURSE TITLE BELOW RECIPIENT NAME
if ($course->fullname == 'Induction - Forklift Operator') {
    certificate_print_text($pdf, $x + 19, $y + 54, 'L', 'Helvetica', 'B', 13, 'Forklift Operator Induction');
}
if ($course->fullname == 'Induction - Tenant Employee') {
    certificate_print_text($pdf, $x + 19, $y + 54, 'L', 'Helvetica', 'B', 13, 'Tenant Employee Induction');
}
if ($course->fullname == 'Induction - Buyer') {
    certificate_print_text($pdf, $x + 19, $y + 54, 'L', 'Helvetica', 'B', 13, 'Buyer Induction');
}
if ($course->fullname == 'Induction - Contractor') {
    certificate_print_text($pdf, $x + 19, $y + 54, 'L', 'Helvetica', 'B', 13, 'Contractor Induction');
}
if ($course->fullname == 'Induction - Tenant Principal') {
    certificate_print_text($pdf, $x + 19, $y + 54, 'L', 'Helvetica', 'B', 13, 'Tenant Principal Induction');
}

//certificate_print_text($pdf, $x, $y + 55, 'C', 'Helvetica', '', 20, get_string('statement', 'certificate'));
//certificate_print_text($pdf, $x, $y + 102, 'C', 'Helvetica', '', 10, certificate_get_grade($certificate, $course));
//certificate_print_text($pdf, $x, $y + 112, 'C', 'Helvetica', '', 10, certificate_get_outcome($certificate, $course));
if ($certificate->printhours) {
    certificate_print_text($pdf, $x, $y + 122, 'C', 'Helvetica', '', 10, get_string('credithours', 'certificate') . ': ' . $certificate->printhours);
}

// OUTPUT ACCESS CARD INFORMATION
if (!$USER->department) {
    certificate_print_text($pdf, $x + 140, $y + 35, 'L', 'Helvetica', '', 19, 'TBA');
} else {
	certificate_print_text($pdf, $x + 140, $y + 35, 'L', 'Helvetica', '', 19, $USER->department);
}

// OUTPUT EMPLOYER NAME INFORMATION
if (!$USER->institution) {
    certificate_print_text($pdf, $x + 49, $y + 70, 'L', 'Helvetica', '', 13, 'TBA');
} else {
	certificate_print_text($pdf, $x + 49, $y + 70, 'L', 'Helvetica', '', 13, $USER->institution);
}

certificate_print_text($pdf, $x + 49, $y + 90, 'L', 'Helvetica', '', 13,  certificate_get_date($certificate, $certrecord, $course));

// OUTPUT CUSTOM TEXT FIELD (YEAR) IN FRONT OF CERTIFICATE CODE
certificate_print_text($pdf, $x + 140, $y + 90, 'L', 'Helvetica', '', 13, $certificate->customtext. '-'. certificate_get_code($certificate, $certrecord));

$i = 0;
if ($certificate->printteacher) {
    $context = get_context_instance(CONTEXT_MODULE, $cm->id);
    if ($teachers = get_users_by_capability($context, 'mod/certificate:printteacher', '', $sort = 'u.lastname ASC', '', '', '', '', false)) {
        foreach ($teachers as $teacher) {
            $i++;
            certificate_print_text($pdf, $sigx, $sigy + ($i * 4), 'L', 'Helvetica', '', 12, fullname($teacher));
        }
    }
}

//certificate_print_text($pdf, $custx, $custy, 'L', null, null, null, $certificate->customtext);
?>