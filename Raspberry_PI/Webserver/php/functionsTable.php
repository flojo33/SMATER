<?php include_once("mysql.php"); ?>
<table class="table table-shadow table-multiline-striped">
	<tr><th>ID</th><th>Name</th><th>Befehlstext</th><th>Aktionen</th></tr>
	<tr><th></th><th colspan="3">API Link</th></tr>
	<?php
		//Get Array of all Functions
    	$functions = Query("*","functions");
    	$API_KEY = Query("*","settings")[0]["value"];
    	//For each function in Functions
    	for($i = 0; $i  < count($functions); $i++)
    	{
	    	//Get the current Function
	    	$function = $functions[$i];
	    	//Get request id for function
	    	$request_id = $function["request_id"];
	    	//Get Request with request id
	    	$request = Query("*","requests","id = $request_id")[0];
	    	//Get Function ID
	    	$id = $function["id"];
	    	//Get Function Name
	    	$name = $function["name"];
	    	//Get Function Request Text
	    	$text = $request["requestString"];
	    	//Get Function Request Audio.wav
	    	$file = $request["file"];
	    	
	    	$btn_audio = "<a class='btn btn-secondary btn-sm btn-fixed-width' href='requestAudio/$file' target='blank'><i class='fa fa-download'></i> Audio</a>";
	    	$btn_remove = "<a class='btn btn-sm btn-warning btn-fixed-width' href='#' onclick='RemoveFunction($id); return false;'><i class='fa fa-trash'></i> Entfernen</a>";
	    	$btn_execute = "<a class='btn btn-sm btn-primary btn-fixed-width' href='#' onclick='SendText(\"$text\"); return false;'><i class='fa fa-play'></i> Ausführen</a>";
	    	$link_input = "<input onClick='this.setSelectionRange(0, this.value.length)' class='form-control' value='http://smater.diebayers.de/?f=function&func_id=$id&key=$API_KEY'>";
	    	
	    	echo "
	    		<tr>
	    			<td>$id</td>
	    			<td>$name</td>
	    			<td>$text</td>
	    			<td>$btn_execute $btn_audio $btn_remove</td>
	    		</tr>
	    		<tr>
	    			<td></td>
	    			<td colspan='3'>$link_input</td>
	    		</tr>
	    	";
    	}
    ?>
</table>