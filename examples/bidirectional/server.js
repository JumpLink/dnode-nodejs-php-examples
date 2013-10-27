var dnode = require('dnode');

var server = dnode(function (remote, conn) {
    this.clientTempF = function (cb) {
      remote.temperature(function(degC){
        degF = Math.round(degC * 9 / 5 + 32);
        cb(degF);
      });
    };
});
server.listen(6060);