<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 2017/12/5
 * Time: 18:54
 */

header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
include 'ConnectSQLite.php';
require_once('../tcpdf/tcpdf.php');

$note = $_POST['noteName'];
$notebookName = $_POST['notebookName'];

$sql = "select content,username from notes where note = '{$note}' and notebook = '{$notebookName}'";
$ret = $db->query($sql);
$row=$ret->fetchArray(SQLITE3_ASSOC);
$content =$row['content'];
$username = $row['username'];

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator($username);
$pdf->SetAuthor($username);
$pdf->SetTitle($note);
$pdf->SetSubject($notebookName);
$pdf->SetKeywords("");

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $notebookName . " - " . $note, "made by " . $username);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('stsongstdlight', '', 14);

// add a page
$pdf->AddPage();
$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
$pdf->Output("'" . $notebookName . "'-'" . $note . ".pdf'", 'I');

