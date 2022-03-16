<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Discount list</title>
   <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="style.css">
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
   <body class="container row justify-content-center mt-5">
      <?php
         $result = file_get_contents('discount.json');
         $discount = json_decode($result, true);
      ?>
      <style type="text/css">
         
      </style>

      <table class="table table-bordered text-center text-light col-5 w-auto" tyle="height: auto">
         <thead class="bg-info">
            <th>Serial No</th>
            <th>Min</th>
            <th>Max</th>
            <th>Discount(%)</th>
            <th>Fix Price(per)</th>
            
         </thead>
         <tbody class="bg-secondary">
            <?php foreach($discount as $key => $row){ ?>
               <tr>
                  <td class="bg-info"><?=$key+1;?></td></td>
                  <td><?=$row['min'];?></td></td>
                  <td><?=$row['max'];?></td></td>
                  <td><?=$row['discount'];?>%</td></td>
                  <td>$<?=$row['fixPrice'];?></td></td>
               </tr>
            <?php } ?>
         </tbody>
      </table>

      <table class="table table-bordered w-auto col-5 ml-3">
            <tbody class="text-center">
               <tr>
                  <td>Name</td>
                  <td>
                     <img src="images/pepsi.jpg" width="120" height="100">
                     <small>Pepsi</small>
                  </td>
               </tr>
               <tr>
                  <td>Price</td>
                  <td> $<?= $per = 10;?> /per</td>
               </tr>
               <tr>
                  <td> Total </td>
                  <td>
                     <input type="text" class="total" value="$10" style="width:auto; text-align: center;" disabled>
                  </td>
               </tr>
               <tr class="yourSave bg-warning">  
               </tr>

               <tr>
                  <td>Increase Vs Decrease</td>
                  <td>
                     <button type="button" class="btn btn-primary btn-sm minus rounded">-</button>
                     <input type="number" class="count text-center" name="qty" value="1">
                     <button type="button" class="btn btn-secondary btn-sm plus rounded">+</button>  
                  </td>
               </tr>
            </tbody>
      </table>
      
      <script type="text/javascript">
         $(document).ready(function(){

            var result = <?php echo $result; ?>;
            var perProduct = <?php echo $per; ?>;

            $('.count').prop('disabled', true);
            $(document).on('click','.plus',function(){
               $('.count').val(parseInt($('.count').val()) + 1);

               $.each(result, function(key, value){
                  var min = value.min;
                  var max = value.max;
                  var discountVal = value.discount;

                  if ($('.count').val() >= min && $('.count').val() <= max){

                     var value = $('.count').val() * perProduct;
                     var discount = parseFloat(value * (discountVal/100)).toFixed(2);
                     var withPercentage = '$'+discount+' (' + discountVal + '%)';                  
                     var total = Math.ceil(parseFloat(value - discount).toFixed(2));

                     if (discount>0){
                        $(".yourSave").show();
                        $('.yourSave').html('');
                        $('.yourSave').append('<td>Your save</td><td><input type="text" class="save" style="width:auto; text-align: center;" disabled></td>');
                        $('.save').val(withPercentage);
                        $('.total').val();
                        $('.total').val('$'+total);

                        if($('.count').val() == result[result.length - 1].max){
                           $('.plus').attr('disabled','disabled');
                        }
                        return false;
                     }

                  }else{
                     $('.total').val();
                     $('.total').val('$'+($('.count').val() * perProduct));
                  }
               });

            });

            $(document).on('click','.minus',function(){
               $('.count').val(parseInt($('.count').val()) - 1 );
               if ($('.count').val() == 0) {
                  $('.count').val(1);
               }

               if($('.count').val() < result[0].min){
                  $(".yourSave").hide();
               }

               $.each(result, function(key, value) {
                  var min = value.min;
                  var max = value.max;
                  var discountVal = value.discount;

                  if($('.count').val() >= (result[result.length - 1].max)-1){
                     $('.plus').removeAttr('disabled');
                  }

                  if ($('.count').val() >= min && $('.count').val() <= max){
                     var value = $('.count').val() * perProduct;

                     var discount = parseFloat(value * (discountVal/100)).toFixed(2);
                     var withPercentage = '$'+discount+' (' + discountVal + '%)';

                     var total = Math.ceil(parseFloat(value - discount).toFixed(2));

                     if (discount>0){
                        $('.yourSave').html('')
                        $('.yourSave').append('<td>Your save</td><td><input type="text" class="save" style="width:auto; text-align: center;" disabled></td>');
                        $('.save').val(withPercentage);
                        $('.total').val();
                        $('.total').val('$'+total);
                        return false;
                     }
                  }else{
                     $('.total').val();
                     $('.total').val('$'+($('.count').val() * perProduct));
                  }
               });

            });
         });
      </script>

   </body>
</html>