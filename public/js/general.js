// generate reandom string 
getRndomString = function (length) {
    var result = '',
            chars = '!-().0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (var i = length; i > 0; --i)
        result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
};


// getnerat random small alphabet 
getRandomAlphabet = function (length) {
    var result = '',
            chars = 'abcdefghijklmnopqrstuvwxyz';
    for (var i = length; i > 0; --i)
        result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
};


function formatMoney(str) {
    if(str.length > 0){
     return str.split('').reverse().reduce((prev, next, index) => {
         return ((index % 3) ? next : (next + ',')) + prev
     })
     }else{
         return 0;
     }
}