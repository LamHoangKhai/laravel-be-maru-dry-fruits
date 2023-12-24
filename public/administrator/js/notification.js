
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('d66d111ae83fbb80e079', {
  cluster: 'ap1'
});

var channel = pusher.subscribe('popup-channel');
channel.bind('user-order', function (data) {
  const Toast = Swal.mixin({
    toast: true,
    position: "top",
    iconColor: "white",
    width: 400,
    customClass: {
      popup: "colored-toast",
    },
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
  });
  Toast.fire({
    icon: "success",
    title: "You have a new order",
  });
});


channel.bind('feedback', function (data) {
  const Toast = Swal.mixin({
    toast: true,
    position: "top",
    iconColor: "white",
    width: 400,
    customClass: {
      popup: "colored-toast",
    },
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
  });
  Toast.fire({
    icon: "success",
    title: "You have a feedback",
  });
});


