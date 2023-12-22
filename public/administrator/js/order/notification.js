   
          // Enable pusher logging - don't include this in production
          Pusher.logToConsole = true;
      
          var pusher = new Pusher('d66d111ae83fbb80e079', {
            cluster: 'ap1'
          });
      
          var channel = pusher.subscribe('popup-channel');
          channel.bind('user-order', function(data) {
            toastr.success('You have a new order');
            // alert(JSON.stringify(data));
          });