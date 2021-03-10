<?php

require_once('lib/classes/DB/Database.php');

require_once('lib/classes/BTable/BuildForm.php');
//$DB = new Database();

$CategoryesForm = new BuildForm("sections");

$ProductsForm = new BuildForm("products");

?>

<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
	<title>Тестовое задание</title>
	<style>
		.error_input{
			border-color:#dc3545;
		}
		
		.popup-fade {
			display: none;
		}
		
		.popup-fade:before {
			content: '';
			background: #000;
			position: fixed; 
			left: 0;
			top: 0;
			width: 100%; 
			height: 100%;
			opacity: 0.7;
			z-index: 9999;
		}
		
		.popup {
			position: fixed;
			top: 20%;
			left: 35%;
			padding: 10px;
			width: 800px;
			height: 250px;
			margin-left: -200px;	
			background: #fff;
			border: 1px solid orange;
			border-radius: 4px; 
			z-index: 99999;
			opacity: 1;	
		}

		.popup-close {
			position: absolute;
			top: 10px;
			right: 10px;
		}
	</style>
	
</head>
<body>
	
	<div class="container" id="rr"><br>Тестовое задание<hr><br></div>
	<div class="container" id="test"></div>
	<div class="container">
	
		<?=$CategoryesForm->getAddForm("myForm");?>
		
	</div>
	
	<br>
	
	<div class="container" id="table-category"></div>
	
	<br>
	
	<div class="container" id="list-product"></div>
	
	<br>
	
	<div class="container">
	
		<?=$ProductsForm->getAddForm("myForm");?>
		
	</div>
	
	<br>
	
	<div class="container" id="table-product"></div>
	
	<br>
	
	<div class="popup-fade">
		<div class="popup">
			<a class="popup-close" href="#">Закрыть</a>
			<p id="modal"></p>
		</div>		
	</div>

	<script src="lib/scripts.js"></script>
	
<script>
	
</script>
	
<script>
	function ajaxEditForm(Data){
		$.ajax({
			type: "POST",
			url: "modal_form.php",  
			cache: false,
			data: Data,
			success: function(html){
				
				$("#modal").html(html).queue(function() {
					
					$.each(Data, function( index, value){
						if(index === "table"){return;}
						if(index === "id"){
							$('#modal').children('form').prepend('<input type="hidden" name="id" value="' + value + '">');
							
							return;
							
						}
						var input = $('#modal').find('.modal_edit_space[name="' + index + '"]');
						
						if( input.is('input') ) {
							input.val('');
							input.val(value);
						}
						
						if( input.is('select') ) {
							$('.modal_edit_space option[value="' + value + '"]').prop('selected', true);
						}
			
						var value = $('.modal_edit_space[name="type_product"]').val();
			
						if(value == '1'){
				
							$('[name="color"]').prop('disabled', true).val('');
							$('[name="url_brand"]').prop('disabled', true).val('');
				
						}else{
				
							$('[name="color"]').prop('disabled', false);
							$('[name="url_brand"]').prop('disabled', false);
			
						}
					});
				}).dequeue();						
			}  
		});
	}
	
	$(document).on('click', '.popup-open', function(e){
			
		e.preventDefault();
		
		var tbody = $(this).parent().parent();
		
		var Data = {};
		
		Data['table'] = tbody.parent().attr('id');
			
		tbody.each(function(row){
					
			$(this).find('td').each(function(cell){
						
				if(typeof $(this).children().html() === "undefined"){
							
					Data[$(this).attr('id')] = $(this).html();
							
				}
			});
		});
		
		ajaxEditForm(Data);
		
		$('.popup-fade').fadeIn();
		
	});
		
	$('.popup-fade').click(function(e) {
		if ($(e.target).closest('.popup').length == 0) {
			$(this).fadeOut();
			$('#modal').html('');
		}
	});
		
	$('.popup-close').click(function() {
		$(this).parents('.popup-fade').fadeOut();
		$('#modal').html('');
		return false;
	});
</script>

</body>
</html>
