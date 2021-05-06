<html>
<head>
<?php include 'incl.php'; ?>
<title>Register</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script>
function register() {
  var name = document.getElementById("name").value;
  var type = document.getElementById("type").value;
  var title = encodeURIComponent(document.getElementById("title").value);
  var description = encodeURIComponent(document.getElementById("description").value);
  var dataString = 'name=' + name + '&type=' + type + '&title=' + title + '&description=' + description;
  $.ajax({
    type: "POST",
    url: "init.php",
    data: dataString,
    cache: false,
    success: function(html) {}
  });
  return false;
}
</script>
</head>
<body>
<h1>Registration</h1>
<form id="form" name="form">
<label>ID: </label>
<input class="text" placeholder="Your entity unique ID" size=28 id="name" type="text"><br>
<label>Type: </label>
<input class="text" placeholder="Specify your entity type" size=26 id="type" type="text"><br>
<label>Name: </label>
<input class="text" placeholder="Name your entity" id="title" type="text" size=25><br>
<textarea class="text" placeholder="Describe your entity" id="description" rows="8" cols="35"></textarea><br>
<p></p>
<input class="east" id="submit" style="width:150px;height:40px;" onclick="register();window.history.back();" type="button" value="Submit">
<input class="center" id="back" style="width:150px;height:40px;" onclick="window.history.back();" type="button" value="Back">
</form>
</body>
</html>
