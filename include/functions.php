<?php
// Personalized dump function to dump variables (most useful for Array)
function dump($str, $show = "active ", $framework = "materialize"){
  // debug backtrace is a function that makes it possible to trace back where this function is called (the file)
  $bt = debug_backtrace();
  // Orders the debug array you get
  $caller = array_shift($bt);
  // Creates an array witht the complete path to the file this function was called, seperated by a backslash
  $tokens = explode('\\', $caller['file']);
  // Shows the folder/file it was called in
  $file = $tokens[count($tokens) - 2] . '/' . $tokens[count($tokens) - 1];
  // The file where the function is called is put in a string (the whole file contents)
  $readFileStr = file($caller['file']);
  // The specific line the funcion is called is put in a string
  $lineStr = $readFileStr[$caller['line'] -1];
  $regularOutput = preg_match('/\((.*?)\)/', $lineStr, $output);
  // Gets the variable name from the dump() function
  $variableName = str_replace([", 1", ",1", '""', ", "], "", $output[1]);
  $random_digit = mt_rand(10000000, 99999999);
  // Depending on the framework it echos a button to expand or collapse the whole output
  switch ($framework) {
    case 'bootstrap':
      echo '<button class="btn btn-light" data-toggle="collapse" data-target="#' . $random_digit . '">' .$variableName . '</button>';
      echo "<div class='collapse " . $show ."' id='" . $random_digit . "'>";
      echo "var '<strong>" . $variableName . "</strong>' dumped in file: <strong>" . $file . '</strong> on line: <strong>' . $caller['line'] . '</strong><br>';
      echo '<pre>' . var_export($str, true) . '</pre>';
      echo "</div>";
      break;
    case 'materialize':
      echo '<ul class="collapsible">';
      echo '  <li class="' . $show . '">';
      echo '    <div class="collapsible-header">' .$variableName .'</div>';
      echo '    <div class="collapsible-body">';
      echo "var '<strong>" . $variableName . "</strong>' dumped in file: <strong>" . $file . '</strong> on line: <strong>' . $caller['line'] . '</strong><br>';
      echo '      <pre>' . var_export($str, true) . '</pre>';
      echo '    </div>';
      echo '  </li>';
      echo '</ul>';
      break;
    default:

    break;
  }
}

function randomString($length = 10) {
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
