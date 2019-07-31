/** START UP THE APP **/


var Monithon = {
  init: function(){
    console.log('MONITHON V3.0');
    this.selects();
  },

  selects: function(){
    $('.pck').selectpicker();
  }

}

Monithon.init();
