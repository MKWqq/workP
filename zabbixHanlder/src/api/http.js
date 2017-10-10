/**
 * Created by wqq on 2017/4/20.
 */
import $ from 'jquery'
/*SN*/
export const SNLoginHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/sn/login/",type:"get",data:params,dataType:'jsonp',jsonp:'cb'}).then(data=>data)}
export const SNDataHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/sn/find/",type:"get",data:params,dataType:'jsonp',jsonp:'cb'}).then(data=>data)}
export const SNDetailHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/sn/findall/",type:"get",data:params,dataType:'jsonp',jsonp:'cb'}).then(data=>data)}
export const SNLoginCheckHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/sn/logintest",type:"get",data:params,dataType:'jsonp',jsonp:'cb'}).then(data=>data)}
export const SNGetServerMsgHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/sn/hosts/",type:"get",data:params,dataType:'jsonp',jsonp:'cb'}).then(data=>data)}

/*ippool*/
export const ippoolLoginHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/ippool/login",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const ippoolDataHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/ippool/find/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const ippoolnsertHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/ippool/insert",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const ippoolUpdateHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/ippool/updatedo",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const ippoolDeleteHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/ippool/del",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const ippoolTotalHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/ippool/statistics",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const ippoolLoginCheckHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/ippool/logintest",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}

/*gslb-agent*/
export const GslbAgentHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/gslbagent/find/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const GslbAgentLoginHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/gslbagent/login",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const GslbLoginCheckHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/gslbagent/logintest",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}

/*cdn*/
export const CDNDataHTTP=params=>{return $.ajax({url:"http://113.106.250.156:8000/yunwei/index.php/cdn/find/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const CDNExportExcelHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/cdn/export/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const CDNScanChartHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/cdn/findall/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}

/*export*/
export const ExportHTTP_one=params=>{return $.ajax({url:'http://171.221.202.190:11111/phpexcel/export_cpu_merr.php',type:"post",data:params,dataType:'jsonp'}).then(data=>data)}
export const ExportHTTP_two=params=>{return $.ajax({url:'http://171.221.202.190:11111/phpexcel/export_num_cli.php',type:"get",data:params,dataType:'jsonp'}).then(data=>data)}
export const ExportHTTP_three=params=>{return $.ajax({url:'http://171.221.202.190:11111/phpexcel/export_error.php',type:"get",data:params,dataType:'jsonp'}).then(data=>data)}

/*channel*/
export const channelDataHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/channel/find/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const channelSearchHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/channel/findchannel/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const channelUpdateHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/channel/update/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const channelInsertHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/channel/insert/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const channelDeleteAllHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/channel/delall/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const channelDeleteHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/channel/del/",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
//channelDataHTTP,channelSearchHTTP,channelUpdateHTTP,channelInsertHTTP,channelDeleteHTTP,channelDeleteAllHTTP

/*cdr*/
export const cdrDataHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/cdr/find",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}

/*program_ranking*/
export const RankingDataHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/Action/operationApi?apiType=program_ranking",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const ScanHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/Action/zabbixMonthData",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const ScanDetailHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/Action/zabbixMonthDetail",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}

/*acquisition program*/
export const AcquisitionDataHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/show/server/list.php?pagesize=15&type=getlist",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const AcquisitionAddHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/Action/operationApi?apiType=acqu&action=add",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const AcquisitionDeleteHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/Action/operationApi?apiType=acqu&action=del",type:"get",data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}
export const AcquisitionSearchHTTP=params=>{return $.ajax({url:"http://171.221.202.190:11111/yunwei/index.php/Action/operationApi?apiType=acqu&action=list&pagesize=15&actionType=getlistvalue",type:"get",traditional:true,data:params,dataType:"jsonp",jsonp:"cb"}).then(data=>data)}

/*LoginHTTP*/
export const LoginHTTP=params=>{return $.ajax({url:"http://113.106.250.156:8000/zabbix/sessionid.php",type:"get",dataType:"jsonp",jsonp:"cb"}).then(data=>data)}

