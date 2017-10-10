/**
 * Created by wqq on 2017/3/21.
 */
import axios from 'axios'
import Vue from 'vue'
import $ from 'jquery'
import "malihu-custom-scrollbar-plugin"
export const loadingDataHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/servers/hosts",data:params,dataType:"jsonp",jsonp:'cb'}).then(data => data)}
export const CDNDataHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/index.php/action/find",data:params,dataType:"jsonp",jsonp:'cb'}).then(data => data)}
export const serverDataHTTP=params => {return $.ajax({type:"get",url:"http://113.106.250.156:8000/yunwei/index.php/action/serverApi",data:params,dataType:"jsonp",jsonp:"cb"}).then((data)=>data)}
export const buttonTypeHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/servers/find/",data:params,dataType:"jsonp",jsonp:"cb"}).then(data => data)}
export const checkedHTTP=params => {return $.ajax({type:"get",url:"http://113.106.250.156:8000/zabbix/cookietest.php",dataType:"jsonp",jsonp:"callback"}).then(data => data)}
export const insertDataHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/servers/insert/",data:params,dataType:"jsonp",jsonp:"cb"}).then(data => data)}
export const updateDataHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/servers/update/",data:params,dataType:"jsonp",jsonp:"cb"}).then(data => data)}
export const problemFindHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/wrong/find",dataType:"jsonp",jsonp:"cb"}).then(data => data)}
export const addProblemHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/wrong/insert",data:params,dataType:"jsonp",jsonp:"cb"}).then(data => data)}
export const updateProblemHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/wrong/update",data:params,dataType:"jsonp",jsonp:"cb"}).then(data => data)}
//export const programMsgHTTP=params => {return $.ajax({type:"get",url:"http://113.106.250.156:8000/export_error_php.php",data:params,dataType:"jsonp",jsonp:"cb"}).then(data => data)}
export const programMsgHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/index.php/action/serverApi",data:params,dataType:"jsonp",jsonp:"cb"}).then(data => data)}
export const boxDataHTTP=params => {return $.ajax({type:"get",url:"http://171.221.202.190:11111/yunwei/terminal/day",data:params,dataType:"jsonp",jsonp:"cb"}).then(data => data)}

/*LoginHTTP*/
export const LoginHTTP=params=>{return $.ajax({url:"http://113.106.250.156:8000/zabbix/sessionid.php",type:"get",dataType:"jsonp",jsonp:"cb"}).then(data=>data)}



