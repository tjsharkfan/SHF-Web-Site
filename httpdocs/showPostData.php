<html>
<head>
<title>Show all POST data</title>
</head>

<body>

<h2>Displays all POST data</h2>

<table>
    <tr><td>Field Name</tf<td>Value</td</tr>
<?php 
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
?>
</table>>

</body>
</html>
