<html lang="zh-CN">
<head>
<title>Category List</title>
<?php $this->js('path-to-js'); ?>
<?php $this->css('path-to-css'); ?>
</head>
<body>
<pre>
<?php
foreach ($data as $key => $value) {
	echo "[$key] -> ";
	var_dump($value);
	echo '<br>';
}
?>
</pre>
</body>
</html>
