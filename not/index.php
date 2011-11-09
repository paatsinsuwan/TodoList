<?php include('bootstrap.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Todo list</title>
        <!--[if IE]>
                <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.2.1/underscore-min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/backbone.js/0.5.3/backbone-min.js"></script>
		<script src="backbone-localstorage.js" type="text/javascript" charset="utf-8"></script>
		
</head>
<body>
	<div id='todoapp'>
	      <div class='title'>
	        <h1>Todos</h1>
	      </div>
	      <div class='content'>
	        <div id='create-todo'>
	          <input id='new-todo' placeholder='What needs to be done?' type='text' />
	          <span class='ui-tooltip-top'>Press Enter to create this task</span>
	        </div>
	        <div id='todos'>
	          <ul id='todo-list'></ul>
	        </div>
	      </div>
	      <div id='todo-stats'></div>
	    </div>
	    <ul id='instructions'>
	      <li>Double-click to edit a todo.</li>
	      <li>Click, hold and drag to reorder your todos.</li>
	    </ul>
	    <script language="javascript" src="todos.js" type="text/javascript"></script>
</body>
</html>