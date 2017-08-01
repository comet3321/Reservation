<?php
$body = '';
$period = new DatePeriod(
  new DateTime('first day of this month'),
  new DateInterval('P1D'),
  new DateTime('first day of next month')
);

foreach($period as $day){
  if ($day->format('w') % 7 ===0) { $body .= '</tr><tr>'; }
  $body .= sprintf('<td class="youbi_%d">%d</td>', $day->format('w'), $day->format('d'));

}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>calender</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <table>
   <thead>
     <tr>
       <th><a href="">&laquo;</a></th>
       <th colspan="5">August 2015</th>
       <th><a href="">&raquo;</a></th>
     </tr>
   </thead>
   <tbody>
     <tr>
             <td>Sun</td>
             <td>Mon</td>
             <td>Tue</td>
             <td>Wed</td>
             <td>Thu</td>
             <td>Fri</td>
             <td>Sat</td>
           </tr>
           <tr>
            <?php echo $body; ?>
           </tr>
   </tbody>
   <tfoot>
     <tr>
       <th colspan="7"><a href="">Today</a></th>
     </tr>
   </tfoot>
 </table>
  </body>
</html>
