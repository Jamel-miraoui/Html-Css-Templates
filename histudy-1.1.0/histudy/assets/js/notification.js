function showNoty(type, message ) {
   new Noty({
       type: type, // 'success', 'error', 'warning', 'info', etc.
       text: message,
       layout: 'topCenter',
       timeout: 2000 , 
       theme: 'relax'  // Optional: Duration in milliseconds (5 seconds here)
   }).show();
}