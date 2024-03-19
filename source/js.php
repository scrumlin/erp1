 <script src="assets/js/jquery-3.2.1.min.js"></script>


        <script src="assets/js/popper.min.js"></script>



        <script src="assets/js/bootstrap.min.js"></script>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>

    <script src="assets/plugins/datatables/datatables.min.js"></script>

        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

		<script src="assets/plugins/raphael/raphael.min.js"></script>    

		<script src="assets/plugins/morris/morris.min.js"></script>  

		<script src="assets/js/chart.morris.js"></script>


		<script  src="assets/js/script.js"></script>
    <script  src="assets/js/select2.min.js"></script>

<script  src="assets/js/jquery.validate.min.js"></script>

    
		
<script>

  function show_waremodal(i)

  { 		 

  	$.ajax({

  		url: 'ajax/ware_ajax.php?action=ware_view',

  		type: 'post',

  		data: {'ware_id': i}, 

  		success: function(data, status) {

  			var user = JSON.parse(data); 

  			$('#edit_ware_type').modal('show');

  			$('#loan_namee').val(user.loan_namee);			

  			$('#loan_codee').val(user.loan_codee);

  			$('#locationn').val(user.loan_typee);

  			$('#ware_id').val(user.id); 

  		}

  	});  

  	return false;

  }

  $("form[name='edit_ware_types']").validate({

  	rules: {

  		spec: "required"	 

  	},

  	messages: {	  

  	},

  	submitHandler: function(form) 

  	{

  		$('.btn-edit').text('Saving...'); 

  		var form = $('#edit_ware_types')[0]; 

  		event.preventDefault();	

  		var data = new FormData(form); 

  		$.ajax({

  			type: "POST",

  			url: "ajax/ware_edit_ajax.php?action=editware",

  			data: data,

  			processData: false,

  			contentType: false,

  			cache: false,

  			timeout: 600000,

  			success: function (data) {

  				alert(data);

  				self.location="procurment_master_ware_house_master.php"; 				

  			},

  			error: function (e) {						

  				console.log("ERROR : ", e);				



  			}

  		}); 

  		return false;

  	}

  });  

</script>


<script>

  function show_unitmodal(i)

  {      

    $.ajax({

      url: 'ajax/unit_ajax.php?action=unit_view',

      type: 'post',

      data: {'unit_id': i}, 

      success: function(data, status) {

        var user = JSON.parse(data); 

        $('#edit_unit').modal('show');

        $('#code').val(user.code);      

        $('#name').val(user.name);

        $('#unit_id').val(user.id); 

      }

    });  

    return false;

  }

  $("form[name='edit_unit1']").validate({

    rules: {

      spec: "required"   

    },

    messages: {   

    },

    submitHandler: function(form) 

    {

      $('.btn-edit').text('Saving...'); 

      var form = $('#edit_unit1')[0]; 

      event.preventDefault(); 

      var data = new FormData(form); 

      $.ajax({

        type: "POST",

        url: "ajax/unit_edit_ajax.php?action=editunit",

        data: data,

        processData: false,

        contentType: false,

        cache: false,

        timeout: 600000,

        success: function (data) {

          alert(data);

          self.location="procurment_master_unit_master.php";        

        },

        error: function (e) {           

          console.log("ERROR : ", e);       



        }

      }); 

      return false;

    }

  });  

</script>


<script>

  function show_taxmodal(i)

  {      

    $.ajax({

      url: 'ajax/tax_ajax.php?action=tax_view',

      type: 'post',

      data: {'tax_id': i}, 

      success: function(data, status) {

        var user = JSON.parse(data); 

        $('#edit_tax_code').modal('show');

        $('#code').val(user.code);      

        $('#name').val(user.name);

        $('#value').val(user.value);

        $('#rdate').val(user.rdate);

        $('#tax_id').val(user.id); 

      }

    });  

    return false;

  }

  $("form[name='edit_taxcode']").validate({

    rules: {

      spec: "required"   

    },

    messages: {   

    },

    submitHandler: function(form) 

    {

      $('.btn-edit').text('Saving...'); 

      var form = $('#edit_taxcode')[0]; 

      event.preventDefault(); 

      var data = new FormData(form); 

      $.ajax({

        type: "POST",

        url: "ajax/tax_edit_ajax.php?action=edittax",

        data: data,

        processData: false,

        contentType: false,

        cache: false,

        timeout: 600000,

        success: function (data) {

          alert(data);

          self.location="procurment_master_tax_code_master.php";        

        },

        error: function (e) {           

          console.log("ERROR : ", e);       



        }

      }); 

      return false;

    }

  });  

</script>


<script>

  function show_itemmodal(i)

  {      

    $.ajax({

      url: 'ajax/item_ajax.php?action=item_view',

      type: 'post',

      data: {'item_id': i}, 

      success: function(data, status) {

        var user = JSON.parse(data); 

        $('#edit_item_category').modal('show');

        $('#code').val(user.code);      

        $('#name').val(user.name);

        $('#item_id').val(user.id); 

      }

    });  

    return false;

  }

  $("form[name='item_cat']").validate({

    rules: {

      spec: "required"   

    },

    messages: {   

    },

    submitHandler: function(form) 

    {

      $('.btn-edit').text('Saving...'); 

      var form = $('#item_cat')[0]; 

      event.preventDefault(); 

      var data = new FormData(form); 

      $.ajax({

        type: "POST",

        url: "ajax/item_edit_ajax.php?action=edititem",

        data: data,

        processData: false,

        contentType: false,

        cache: false,

        timeout: 600000,

        success: function (data) {

          alert(data);

          self.location="procurment_master_item_category_master.php";        

        },

        error: function (e) {           

          console.log("ERROR : ", e);       



        }

      }); 

      return false;

    }

  });  

</script>



    </body>


</html>