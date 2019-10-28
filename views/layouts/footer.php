<!-- /.content -->

  <div class="chat-popup" style="bottom: 0; border-radius: 15px 15px 0 0;" id="chat_box">
    <div class="chat-header bg bg-green">
      <button type="button" class="btn cancel" onclick="closeForm()"><i class="fas fa-times"></i></button>
      <h5 class="person_name"></h5>
    </div>
    <div class="chat-body">

    </div>
    <form action="" class="form-container">
      <input type="hidden" name='person_id'>
      <input type="hidden" name='person_name'>
      <input type="hidden" name='person_type'>
      <textarea class="form-control" placeholder="Type message.." name="message" required></textarea>
      <button type="button" id="submit_message" class="btn btn-danger pull-right">Send</button>
    </form>
  </div>

  <script>
    $(".msg-icon").click(function(){
      $.get('?c=ajax&m=getMessageList', {}, function(result) {
        $('#message_list').html(result);
        //console.log(result);
      });
    });

    $('#message_list').on('click', 'li', function(){
      var id = $(this).data('id');
      var name = $(this).data('name');
      var person_type='';
      $('.person_name').html(name);
      $('input[name="person_id"]').val(id);
      $('input[name="person_name"]').val(name);
      if(typeof(id)=='number'){
         $('input[name="person_type"]').val('work');
      }
      if(typeof(id)=='string'){
         $('input[name="person_type"]').val('person');
      }
      person_type =$('input[name="person_type"]').val();
      openForm(id, name, person_type);
    });

    $('.person_list').on('click', 'li', function(){
      $('input[name="chat_search"]').val('');
      $('.person_list').fadeOut();
      var id = $(this).data('id');
      var name = $(this).data('name');
      var person_type='';
      $('.person_name').html(name);
      $('input[name="person_id"]').val(id);
      $('input[name="person_name"]').val(name);
      if(typeof(id)=='number'){
        $('input[name="person_type"]').val('work');
      }
      if(typeof(id)=='string'){
        $('input[name="person_type"]').val('person');
      }
      person_type = $('input[name="person_type"]').val();
      openForm(id, name, person_type);
    });


    function refreshMessage(id, type=''){
      $.ajax({
        type:"GET", 
        url: "?c=ajax&m=getMessages",
        data: {
          id: id
        },
        success: function(data) {
        //console.log(data);
        $(".chat-body").html(data);
      }
    });
      $(".chat-body").stop().animate({ scrollTop: $(".chat-body")[0].scrollHeight}, 1000);
  }

    function openForm(id, name, ty) {
      $("#chat_box").fadeIn();
      $.get('?c=ajax&m=changeWorkMessageStatus', {id: id, ty: ty}, function(result) {
        refreshMessage(id, name);
      });
    }
    function closeForm() {
      //document.getElementById("chat_box").style.display = "none";
      $("#chat_box").fadeOut();
    }

    $(document).ready(function(){
    var id          = $('input[name="person_id"]').val();
    var name        = $('input[name="person_name"]').val();
    var person_type = $('input[name="person_type"]').val();

    //refreshMessage(id, person_type);    
    function storeMessages(id, ty){
      var message     = $('textarea[name="message"]').val();
      $.get('?c=ajax&m=storeWorkMessages', {person_id: id, person_type: ty, message: message}, function(result) {
      });
      $('textarea[name="message"]').val('');
    }

    $("#submit_message").click(function(){
      var id          = $('input[name="person_id"]').val();
      var name        = $('input[name="person_name"]').val();
      var person_type = '';
      if(typeof(id)=='number'){
         $('input[name="person_type"]').val('work');
      }
      if(typeof(id)=='string'){
         $('input[name="person_type"]').val('person');
      }
      person_type = $('input[name="person_type"]').val();
      storeMessages(id, person_type);
      refreshMessage(id, person_type);
      $(".chat-body").stop().animate({ scrollTop: $(".chat-body")[0].scrollHeight}, 1000);
    }); 

    $('input[name="chat_search"]').on('keyup', function (e) {
      var key = this.value;
      if (key != '') {
        $.ajax({
          url:"?c=ajax&m=getPersonForChat",
          method:"POST",
          data:{key:key},
          dataType:"text",
          success:function(data){
            $('.person_list').fadeIn();
            $('.person_list').html(data);
            //console.log(key);
          }
        });
      }
    });

    $('.chat-popup').on('keypress', function (e) {
      var id          = $('input[name="person_id"]').val();
      var name        = $('input[name="person_name"]').val();
      var person_type = '';
      if(typeof(id)=='number'){
         $('input[name="person_type"]').val('work');
      }
      if(typeof(id)=='string'){
         $('input[name="person_type"]').val('person');
      }
      person_type = $('input[name="person_type"]').val();
      if (e.which==13) {
        storeMessages(id, person_type);
        refreshMessage(id, person_type)
        $(".chat-body").stop().animate({ scrollTop: $(".chat-body")[0].scrollHeight}, 1000);
      }

    });
  });

  function newMessageCount(){
     var id          = $('input[name="person_id"]').val();
      var name        = $('input[name="person_name"]').val();
      var person_type = '';
      if(typeof(id)=='number'){
         $('input[name="person_type"]').val('work');
      }
      if(typeof(id)=='string'){
         $('input[name="person_type"]').val('person');
      }
      person_type = $('input[name="person_type"]').val();
    $.ajax({
      type:"GET", 
      url: "?c=work&m=newMessagesCount",
      data: {
        id: id
      },
      success: function(data) {
        //console.log(data);
        $("#new-comments").html(data);
      }
    });
  }
  setInterval(newMessageCount,1000);
</script>


<footer class="main-footer">
    <!-- <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div> -->
    <strong>Copyright &copy; <?php echo date('Y') ?> <a href="https://adminlte.io">Bangladesh Software Development - BSD</a>.</strong> All rights
    reserved.
  </footer>

  
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->


<!-- Bootstrap 3.3.6 -->
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<!-- iCheck -->

<script type="text/javascript" src="plugins/iCheck/icheck.min.js"></script>

<script type="text/javascript" src="assets/js/moment.js"></script>
<script type="text/javascript" src="assets/js/daterangepicker.js"></script>

<!-- FastClick -->
<script type="text/javascript"  src="assets/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript"  src="assets/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script type="text/javascript" src="assets/js/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="assets/js/select2.full.min.js"></script>

<!-- jvectormap  -->
<!--<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>-->
  <!-- SlimScroll -->
  <!--<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>-->
  <!-- ChartJS -->

  <script>
     //Date picker
     $('#datepicker').datepicker({
      format: "yyyy-mm-dd",
      todayBtn: "linked",
      autoclose: true,
      todayHighlight: true
    });


  </script>
  <!--datatable-->


</body>
</html>

