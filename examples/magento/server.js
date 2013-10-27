var dnode = require('dnode');

var server = dnode(function (remote, conn) {
    this.get_product_from_client = function (cb) {
      console.log("Hi! I'm the server in node.js and I will run a function from server in php!");
      remote.items(function(items) {
        console.log(items);
      });
    };
});
server.listen(6060);