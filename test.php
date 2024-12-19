<?php

/**
 * file: EquipmentOrdering/EquipmentOrdering.php
 * @author: M Ahmad 
 * @datetime: 03-DEC-2021
 */


include_once "include_files/Db_class.php";
//getting opertaor's name
$operator = $_SESSION['ssds-id'];
?>

<!--Equipment Ordering Section 1(Material Detail)-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/nhrms/assets/css/datetimepicker.min.css">

<div class="conatiner">
   <div class="row" style="margin-top:1%">
      <div class="col-sm-12">
         <div class="panel panel-white">
            <div class="panel-heading panel-blue border-light">
               <h4 class="panel-title">
                  <i class="fa fa-circle"></i>
                  &nbsp; Customer Detail
               </h4>
            </div>
            <div class="panel-body insert_div">

               <!-- Create New Customer's Details -->
               <div class="row  insert_div ">
                  <div class="col-md-4 mx-2">
                     <div class="form-group">
                        <label for=""><strong>Name:</strong></label>
                        <input type="text" value="" id="Name" name="Name" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for=""><strong>Contact No:</strong></label>
                        <input type="tel" name="ContactNo" value="" id="ContactNo" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for=""><strong>Address:</strong></label>
                        <input type="text" name="Address" value="" id="Address" class="form-control">
                     </div>
                     <button type="submit" id="submit_btn" name="done" onclick="insertDetail();"
                        class="btn btn-primary">Create</button>
                  </div>
               </div>
            </div>
         </div>

         <div class="panel-body update_div" style="display: none;">
            <div class="col-md-12">
               <div class="row">
                  <div class="col-md-4 mx-2">
                     <div class="form-group">
                        <label for=""><strong>Name:</strong></label>
                        <input type="text" value="" id="UpdateName" name="Name" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for=""><strong>Contact No:</strong></label>
                        <input type="tel" name="ContactNo" value="" id="UpdateContactNo" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for=""><strong>Address:</strong></label>
                        <input type="text" name="Address" value="" id="UpdateAddress" class="form-control">
                     </div>
                     <button type="submit" id="submit_btn" name="done" onclick="updateDetails();"
                        class="btn btn-primary">Update</button>
                  </div>
               </div>


               <div>
                  </br></br>

               </div>
            </div>
         </div>


         <!--Material Detail Table-->

         <div class="row">
            <div class="col-md-12">
               <!-- Inner View panel starts here -->
               <div class="panel panel-white" style="margin-top:1%">
                  <div class="panel-heading panel-blue">
                     <h4 class="panel-title">
                        <i class="fa fa-eye"></i>
                        View Customer Details
                     </h4>
                  </div>
                  <div class="panel-body ">
                     <table id="customerTable" class="table table-hover table-striped table-bordered">
                        <thead>
                           <th>Sr.No</th>
                           <th>Name</th>
                           <th>Address</th>
                           <th>Contact Number</th>
                           <th>Operator</th>
                           <th>DateTime</th>
                           <th>Status</th>
                           <th>Updated At</th>
                           <th>Updated By</th>
                           <th>Action</th>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>

<script src="/nhrms/assets/datetimepicker.js"></script>

<script type="text/javascript">

   $(document).ready(function () {
      ShowCustomer();
   });

   function ShowCustomer() {

      $('#customerTable').DataTable({
         destroy: true,
         "ajax":
         {
            "type": 'POST',
            "data":
            {
               action: 'SHOW',
            },
            "dataSrc": "data",
            "columns": [
               { "data": "0" },
               { "data": "1" },
               { "data": "2" },
               { "data": "3" },
               { "data": "4" },
               { "data": "5" },
               { "data": "6" },
               { "data": "7" },
               { "data": "8" },
               { "data": "9" }
            ],
            "url": 'ajax.php',
         }
      });
   }

   function insertDetail() {
      var name;
      var contactNo;
      var address;
      name = $("#Name").val();
      contactNo = $("#ContactNo").val();
      address = $("#Address").val();
      if (name.trim() === '' || contactNo.trim() === '' || address.trim() === '') {
         alert('Please fill in all fields');
         return;
      }
      $.ajax({
         url: "ajax.php",
         method: "POST",
         data: {
            name: name,
            contactNo: contactNo,
            address: address,
            action: 'ADD',
         },
         success: function (data) {
            $('#Name').val('');
            $('#ContactNo').val('');
            $('#Address').val('');
         }
      });
      ShowCustomer()
   }

   function updateDetails() {
      var name;
      var contactNo;
      var address;
      name = $("#UpdateName").val();
      contactNo = $("#UpdateContactNo").val();
      address = $("#UpdateAddress").val();
      $.ajax({
         url: "ajax.php",
         method: "POST",
         data: {
            name: name,
            contactNo: contactNo,
            address: address,
            customer_id: customer_id,
            action: 'UPDATE',

         },
         success: function (data) {
            $('#UpdateName').val('');
            $('#UpdateContactNo').val('');
            $('#UpdateAddress').val('');
         }
      });
      ShowCustomer()

   }

   function deleteCustomer(customerID) {
      customer_id = customerID;
      var isConfirmed = confirm('Are you sure you want to delete this customer?');
      if (isConfirmed) {
         $.ajax({
            url: "ajax.php",
            method: "POST",
            dataType: "json",
            data: {
               action: 'DEL',
               customerID: customerID
            },

            success: function (data) {
               ShowCustomer();
            }
         });
      }
      else {
         return;
      }
   }


   // Function to handle the edit action
   function editCustomer(customerID) {
      $('.insert_div').hide();
      $('.update_div').show();
      customer_id = customerID

      // AJAX request to fetch customer details for the specified ID
      $.ajax({
         url: "ajax.php",
         method: "POST",
         dataType: "json",
         data: {
            action: 'EDIT',
            customerID: customerID
         },
         success: function (data) {
            $('#UpdateName').val(data.NAME);
            $('#UpdateContactNo').val(data.CONTACT_NO);
            $('#UpdateAddress').val(data.ADDRESS);
         }
      });
   }

</script>