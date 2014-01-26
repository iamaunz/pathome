$(document).ready(function() {
	
	
		
					
			
			$(this).delegate('#watergov','click',function(e){
				
				if( $('#watergov').is(":checked") ) {
					//alert('t');
					
				   	$('#waterperunit').attr("disabled", true);
				 } else {
					//alert('f');
					$('#waterperunit').attr("disabled", false);
				 
				 }
			});
			
			$(this).delegate('#charggov','click',function(e){
				
				if( $('#charggov').is(":checked") ) {
					//alert('t');
				   $('#chargeperunit').attr("disabled", true);
				 } else {
					//alert('f');
					$('#chargeperunit').attr("disabled", false);
				 
				 }
			});
			
			/*$('#room').live('click',function(){
					//alert('xxx');
					var month = $('#month').val();
					var year = $('#year').val();
					$(this).attr('href','room.php?month='+month+'&year='+year);
				});*/
				
				
			$('#month').live('change',function(){
				var year = $('#year').val();
				var month = $(this).val();
				//alert(month);
				$('#showreportmonth').load('process.php?task=showreportmonth&year='+year+'&month='+month);
			});
				
			$('#year').live('change',function(){
				var year = $(this).val();
				var month = $('#month').val();
				//alert(month);
				$('#showreportmonth').load('process.php?task=showreportmonth&year='+year+'&month='+month);
			});
			
			$(this).delegate('#room','click',function(){
					var month = $('#month').val();
					var year = $('#year').val();
					$(this).attr('href','room.php?month='+month+'&year='+year);
				});
				
			$(this).delegate('#report','click',function(){
					var month = $('#month').val();
					var year = $('#year').val();
					$(this).attr('href','report.php?month='+month+'&year='+year);
				});
				
			$(this).delegate('#print','click',function(){
					var month = $('#month').val();
					var year = $('#year').val();
					$(this).attr('href','print.php?month='+month+'&year='+year);
				});
					
			$('#apartmentroom').live('change',function(){
				//alert('ddd');
				var id = $(this).val();
				$('#showLevelroom').load('process.php?task=showLevel&id='+id);
			
				//$('#level').append('<option value="foo" selected="selected">Foo</option>');
			});
			
			$('#level').live('change',function(){
				var apartment = $('#apartmentrent').val();
				//alert( apartment + '->'+$(this).val());
				$('#showRoomrent').load('process.php?task=showRoom&apartment='+apartment+'&level='+$(this).val());
			});
			
			$('#apartmentrent').live('change',function(){
				//alert('ddd');
				var id = $(this).val();
				$('#showLevelrent').load('process.php?task=showLevel&id='+id);
			
				//$('#level').append('<option value="foo" selected="selected">Foo</option>');
			});
			
			$('#apartment').live('change',function(){
				//alert('ddd');
				var id = $(this).val();
				$('#showLevel').load('process.php?task=showLevel&id='+id);
			
				//$('#level').append('<option value="foo" selected="selected">Foo</option>');
			});
			
			$('#etc').live('keyup',function(){
				
				var rent = parseFloat($('#rent').val());
				var charge = parseFloat($('#charge').val());
				var water = parseFloat($('#water').val());
				var etc = parseFloat($(this).val());
				
				//alert(rent+charge+water+etc);
				total = (rent+charge+water+etc);
				//number = $.formatNumber(total, {format:"#,###.00", locale:"us"});
				 
				$('#sum').html('<strong>'+ total+'</strong>');
				
				
			});
			
			
			
			$('#apartmentroomfilter').live('change',function(){
				//alert('ddd');
				var txt = $('#search').val();
				var id = $(this).val();
				var year = $('#hiyear').val();
				var month = $('#himonth').val();
				$('#showLevelroomfilter').load('process.php?task=showLevelfilter&id='+id);
				
				$('#loaddata').load('process.php?task=showDataload&idam='+id+'&year='+year+'&month='+month+'&txt='+txt);
			
				//$('#level').append('<option value="foo" selected="selected">Foo</option>');
			});
			
			$('#levelfilter').live('change',function(){
				var txt = $('#search').val();
				var idLv = $(this).val();
				var idAm = $('#apartmentroomfilter').val();
				var year = $('#hiyear').val();
				var month = $('#himonth').val();
				//alert(idAm  + idLv + year+ month)
				$('#loaddata').load('process.php?task=showDataload&idam='+idAm+'&idlv='+idLv+'&year='+year+'&month='+month+'&txt='+txt);
				
			});
			
			
			$('#search').live('keyup',function(){
				
				var txt = $('#search').val();
				var idAm = $('#apartmentroomfilter').val();
				var idLv = $('#levelfilter').val();
				var year = $('#hiyear').val();
				var month = $('#himonth').val();
				//alert(idAm  + idLv + year+ month)
				$('#loaddata').load('process.php?task=showDataload&idam='+idAm+'&idlv='+idLv+'&year='+year+'&month='+month+'&txt='+txt);
			});
			
			month
			
		
			
			
		});