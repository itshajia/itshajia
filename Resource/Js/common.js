/*
 * 后台一些公用方法
 * 不依赖于任何框架 和 DOM
 * */


// 弹出窗口
 function cfirm() {

    if( confirm('确定要执行改操作?') ) {
        return true;
    } else {
        return false;
    }
}

// 获取当前时间
function getDate() {
    var time = new Date();
    var year = time.getFullYear();
    var month = time.getMonth() + 1;
    var date = time.getDate();
    var hour = time.getHours();
    var minute = time.getMinutes();
    var second = time.getSeconds();

    return year +"-"+ month +"-"+ date +" "+ hour +":"+ minute +":"+ second;
}

// 隐藏当前对象
function hide( obj ) {
    obj.style.display = "hidden";
}