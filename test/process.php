<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Auto Submit Form</title>
</head>
<body>

<form id="myForm" action="submit.php" method="POST">
  <label for="name">Name:</label><br>
  <input type="text" id="name" name="name"><br>
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email"><br><br>
  <input type="submit" value="Submit">
</form>

<script>
// Function to auto-submit the form after a certain period of time
function autoSubmitForm() {
  document.getElementById("myForm").submit();
}

// You can call the autoSubmitForm function after a delay, for example, 5 seconds.
setTimeout(autoSubmitForm, 5000); // Auto-submit after 5 seconds
</script>

</body>
</html>
