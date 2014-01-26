<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" content="text/html; charset=UTF-8"> 
<title>Apartment</title>
<link rel="stylesheet" href="js/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="js/jquery.mobile-1.2.0.min.js"></script>
    
</head>

<body>

<div data-role="page">

	<div data-role="header"  data-theme="b" >
		<h1>Apartment</h1>
	</div><!-- /header -->


<form name="admin" method="post" action="controllers.php">
	<div data-role="content"  >	
    	<ul data-role="listview" data-inset="true">
            <li>
            <div data-role="fieldcontain">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username"  required="required" />
            </div>
            <div data-role="fieldcontain">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password"  required="required" />
            </div>
            <input type="hidden" name="task" value="login" />
            <input type="submit" value="Login." />
            
			</li>
        </ul>
	</div><!-- /content -->
</form>


	
</div><!-- /page -->


</body>
</html>