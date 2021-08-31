<?php

namespace Azhar\ELMS;

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;

class Export
{
    public static function mailAndExport($db, int $id) : void
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();
        $mail = new PHPMailer(true);

        $sql = "SELECT u.first_name AS 'first', u.last_name AS 'last', lr.id, lr.reason AS excuse, lr.start_date AS 'start', lr.end_date AS 'end', lr.added_on, ls.status, ls.from_date AS 'from', ls.to_date AS 'to', ls.reason FROM leave_requests lr JOIN users u ON u.id = lr.user_id JOIN leave_status ls ON lr.id = ls.requests_id WHERE u.id = '$id'";

        $result = $db->query($sql);

        if($result->num_rows > 0) {

            $activeSheet->setCellValue('A1', 'ID');
            $activeSheet->setCellValue('B1', 'Reason');
            $activeSheet->setCellValue('C1', 'Start Date');
            $activeSheet->setCellValue('D1', 'End Date');
            $activeSheet->setCellValue('E1', 'Added ON');
            $activeSheet->setCellValue('F1', 'Status');
            $activeSheet->setCellValue('G1', 'FROM DATE');
            $activeSheet->setCellValue('H1', 'TO DATE');
            $activeSheet->setCellValue('I1', 'Reason');

            $i = 2;
			$name = "";
            while($row = $result->fetch_assoc()){
                $activeSheet->setCellValue('A'.$i , $row['id']);
                $activeSheet->setCellValue('B'.$i , $row['excuse']);
                $activeSheet->setCellValue('C'.$i , $row['start']);
                $activeSheet->setCellValue('D'.$i , $row['end']);
                $activeSheet->setCellValue('E'.$i , $row['added_on']);
                $activeSheet->setCellValue('F'.$i , $row['status']);
                $activeSheet->setCellValue('G'.$i , $row['from']);
                $activeSheet->setCellValue('H'.$i , $row['to']);
                $activeSheet->setCellValue('I'.$i , $row['reason']);
                $name = $row["first"].' '.$row["last"].' ';
                $i++;
            }
            $filename = $name.'leave.xlsx';

            if (!file_exists('export')) {
                mkdir('export', 0755);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save('../export/'.$filename);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '##############'; 
            $mail->Password = '##############';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('###############', 'Azhar');
            $mail->addAddress('##############', 'Ajju');

            $mail->addAttachment('export/'.$filename);

            $mail->isHTML(true);
            $mail->Subject = 'Exported Leave File';
            $mail->Body    ='XLSX file attached CHeck out';

            $mail->send();

            echo "Export Successfull Please Check Email";

        } else {
            echo "No data Available";
        }
    }
}

?>