var express=require("./server/node_modules/express");
var ejs=require("./server/node_modules/ejs");
var mycookie=require("./server/node_modules/cookie-parser");
var mysession=require("./server/node_modules/express-session");
var app=express();
/*ejs????*/
app.set("views",__dirname+"/client/view");
app.engine("html",ejs.__express);
app.set("view engine","html");
/*????*/
app.listen(8282,function(){
    console.log("8282正在监听");
});
app.configure(function(){
    /*session??*/
    app.use(mycookie());
    app.use(mysession({
        secret:'1',
        name:'mysession',
        cookie:{maxAge:3000000}
    }));
    /*express????*/
    app.use(express.bodyParser());
    app.use(app.router);
    app.use(express.methodOverride());
    app.use(express.logger('dev'));
    app.use(express.static(__dirname+"/client"));
    app.use(express.errorHandler());
});
app.get("/",function(req,res){
    res.render("index.html");
});
app.get("/index.html",function(req,res){
    res.render("index.html");
});
app.get("/test",function(req,res){
    res.render("test.html")
});
app.get("/contact.html",function(req,res){
    res.render("contact.html")
});
app.get("/product.html",function(req,res){
    res.render("product.html")
});
app.get("/program.html",function(req,res){
    res.render("program.html")
});
app.get("/More.html",function(req,res){
    res.render("More.html")
});
app.get("/mytest.html",function(req,res){
    res.render("mytest.html")
});




