	$('#myForm button[type="submit"]').click(function(e){
		
		e.preventDefault();
		
		var form = $(this).parent().parent('form');
		
		var Fdata = {};
		
		Fdata = form.serializeArray();
		
		$.ajax({
			type: "POST",
			url: "ajaxAdd.php",
			data: Fdata,
			dataType: "json",
			success: function(data){
				
				if(data.result == 'success'){
					
					//location.reload();
					
					alert('Успешно');
					
				}else{
					
					for(var errorField in data.text_error){
						
						alert(data.text_error[errorField]);
						
						$('[name="'+errorField+'"]').addClass('error_input');
						
					}
				}
				
			}
		});
		
		form[0].reset();
		
	});
	
	$(document).on('click', '#EditForm button[type="submit"]', function(e){
		
		e.preventDefault();
		
		var form = $(this).parent().parent('form');
		
		var Fdata = {};
		
		Fdata = form.serializeArray();
		console.log(Fdata);
		$.ajax({
			type: "POST",
			url: "ajaxAdd.php",
			data: Fdata,
			dataType: "json",
			success: function(data){
				
				if(data.result == 'success'){
					
					//location.reload();
					
					alert('Успешно');
					
				}else{
					
					for(var errorField in data.text_error){
						
						alert(data.text_error[errorField]);
						
						$('[name="'+errorField+'"]').addClass('error_input');
						
					}
				}
				
			}
		});
		
		form[0].reset();
		
	});

	function sumProducts(get){
		$.ajax({ 
			url: "sum_products.php" + get,  
			cache: false,
			dataType: "json",
			success: function(data){ 
				alert("Товаров найдено - " + data.count + ". На сумму - " + data.result);  
			}  
		});  
	}
		
	function showTableCategory(){
		$.ajax({ 
			url: "table_categoryes.php",  
			cache: false,  
			success: function(html){  
				$("#table-category").html(html);  
			}  
        });  
	}
	
	function showListedCategory(){
		$.ajax({  
			url: "listed_categoryes.php",  
			cache: false,  
			success: function(html){  
				$("#list-product").html(html);  
			}  
        });  
	}
	
	function showTableProduct(get){
		if(typeof get === "undefined"){
			
			get = "?category=0";
			
		}
			$.ajax({  
				url: "table_products.php" + get,  
				cache: false,  
				success: function(html){  
					$("#table-product").html(html);  
				}  
            });  
	}
	
	var idGet;
	
	$(document).ready(function(){
		
		$(document).on('click', '#delite_this_element', function(){
			
			if(confirm("Are you sure?")){
				
				var parentTr = $(this).parent().parent();
				var idTr = parentTr.attr("id");
				var tableName = parentTr.parent().attr("id");
				var get_param = "?table="+tableName+"&id=" + idTr;
			
				$.ajax({
					url: "delite.php" + get_param,
					cache: false
				});
			
				alert('Удалена строка с ID - ' + idTr);
				
			}
			
		});
		
		$('#list-product').on('click', 'a', function(e){
		
			e.preventDefault();
		
			idGet = $(this).attr('href');
			
			showTableProduct(idGet);
		
		});
		
		$('#list-product').on('click', 'button#modal_sum', function(e){
			
			e.preventDefault();
		
			sumProducts($(this).attr('href'));
		
		});
		
		$('[name="type_product"]').on('change', function(){
			
			var value = $(this).val();
			
			if(value == '1'){
				
				$('[name="color"]').prop('disabled', true).val('');
				$('[name="url_brand"]').prop('disabled', true).val('');
				
			}else{
				
				$('[name="color"]').prop('disabled', false);
				$('[name="url_brand"]').prop('disabled', false);
			
			}
			
		});
			
		showTableCategory();
		showListedCategory();
		showTableProduct(idGet);
		
		setInterval('showTableCategory()',1000);
		setInterval('showListedCategory()',1000);
		setInterval('showTableProduct(idGet)',1000);
		
	});
	
	
		
	
