
function insToSql(insFormName,height,title)
{	  
     $('<div>').load(insFormName).dialog({
        modal: true,     
        resizable: false,
		title: title,
        height:height,
		width: 500,
        modal: true,
        buttons: {
            "Затвори": function() {   
                 $( this ).dialog( "close" );            				 
             },           
         },
     });
    return false;
}
 function confirmMessage(pr_id)
{ 
     $('<div>').dialog({
        modal: true,
        open: function ()
         {   		                   
		    $(this).html('<div><strong>Наистина ли желаете да изтриете продукта ?</strong></div>');				
         },        
        resizable: false,
		title: "Информация",
        height:200,
		width: 370,
        modal: true,
        buttons: {
            "Да": function() {             			
                 $( this ).dialog( "close" );			
				 deleteProdukt(pr_id);
	             },
             Не: function() {
                 $( this ).dialog( "close" );
             },
         },
     });
     
   return false;
 }
 
 function deleteProdukt(pr_id)
 { 
        var msg = "";
        data = {id: pr_id};
        // Message(data);
        $.ajax({
        type: "POST",
        url: 'delete_product.php',
        data: data
        }).done(function( msg ) {
           Message("Действието е извършено успешно ! " + msg);
        });
	  return false;
 }
 
  function confirmMessageContractor(contractor_id)
{    
  
     $('<div>').dialog({
        modal: true,
        open: function ()
         {   		                   
		    $(this).html('<div><strong>Наистина ли желаете да изтриете доставчика ?</strong></div>');				
         },        
        resizable: false,
		title: "Информация",
        height:200,
		width: 370,
        modal: true,
        buttons: {
            "Да": function() {             			
                 $( this ).dialog( "close" );			
				 deleteContractor(contractor_id);
	             },
             Не: function() {
                 $( this ).dialog( "close" );
             },
         },
     });
    
   return false;
 }
 
  function deleteContractor(contractor_id)
 { 
        var msg = "";
        data = {id: contractor_id};
        // Message(data);
        $.ajax({
        type: "POST",
        url: 'delete_customer.php',
        data: data
        }).done(function( msg ) {
           Message("Действието е извършено успешно ! " + msg);
        });
	  return false;
 }
 
function editProdukt(pr_id)
 {      
       // Message(pr_id);
       $('<div>').load('update_form.php?id='+pr_id).dialog({
        modal: true,     
        resizable: false,
		title: "Редакция на продукт",
        height:650,
		width: 500,
        modal: true,
        buttons: {
            "Затвори": function() {   
                 $( this ).dialog( "close" );            				 
             },           
         },
     });
    return false;
 }
 
 function editCustomer(customer_id)
 {      
        //Message(customer_id);
       $('<div>').load('update_distributor.php?id='+customer_id).dialog({
        modal: true,     
        resizable: false,
		title: "Редакция на доставчик",
        height:560,
		width: 500,
        modal: true,
        buttons: {
            "Затвори": function() {   
                 $( this ).dialog( "close" );            				 
             },           
         },
     });
    return false;
 }
 
function Message(msg)
{
     $('<div>').dialog({
        modal: true,
        open: function ()
         {   		                   
		    $(this).html('<div><strong>'+msg+'</strong></div>');				
         },        
        resizable: false,
		title: "Информация",
        height:200,
		width: 370,
        modal: true,
        buttons: {
            "Затвори": function() {   
                 $( this ).dialog( "close" );	
                 //refresh();				 
             },           
         },
     });
     return false;
}

function refresh()
{
  document.location.reload(true);
}

