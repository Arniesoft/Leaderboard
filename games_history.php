<?php
require_once 'admin/config.php'; // Database en configuratie

$sql = "SELECT a.naam as speler1, b.naam as speler2, matches.score_winnaar, matches.score_verliezer, matches.datum, matches.flag, matches.draw 
        FROM matches 
        LEFT JOIN spelers a ON matches.winnaar_id = a.speler_id 
        LEFT JOIN spelers b ON matches.verliezer_id = b.speler_id 
        ORDER BY matches.datum DESC";

if ($result = $mysqli->query($sql)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            // Als flag is ingevuld, toon gevlagde game met speciale stijl
            if (!empty($row['flag'])) {
                echo "<p style='color: red; font-style: italic; text-decoration: line-through; display: inline;'>"
                     . $row["datum"] . " - Speler: " . ($row["speler1"] ?? 'Onbekend') .
                     " - Score: " . $row["score_winnaar"] . " - VS - Score: " . $row["score_verliezer"] .
                     " - Speler: " . ($row["speler2"] ?? 'Onbekend') . "</p>"
                     . "<span style='color: red; font-style: italic; text-decoration: none;'> *(Reden: " . htmlspecialchars($row['flag']) . ")*</span><br>";
            }
            // Als het een gelijkspel is, toon met schuine stijl
            else if ($row['draw'] == 1) {
                echo "<p style='font-style: italic;'>" . $row["datum"] . " - Speler: " . ($row["speler1"] ?? 'Onbekend') .
                     " - Score: " . $row["score_winnaar"] . " - VS - Score: " . $row["score_verliezer"] .
                     " - Speler: " . ($row["speler2"] ?? 'Onbekend') . "</p><br>";
            }
            // Voor een normale wedstrijd zonder flag of draw
            else {
                echo "<p>" . $row["datum"] . " - Speler: " . ($row["speler1"] ?? 'Onbekend') .
                     " - Score: " . $row["score_winnaar"] . " - VS - Score: " . $row["score_verliezer"] .
                     " - Speler: " . ($row["speler2"] ?? 'Onbekend') . "</p><br>";
            }
        }
    } else {
        echo "<p>Geen matchgegevens beschikbaar.</p>";
    }
} else {
    echo "<p>Fout bij ophalen van gegevens: " . $mysqli->error . "</p>";
}
?>
