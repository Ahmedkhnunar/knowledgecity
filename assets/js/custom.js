function AjaxRequest(params,method='GET')
{
    let urlParams = "?";
    $.each(params,function(k,v){
      urlParams =  urlParams + k +"=" + v +"&";
    });
    urlParams = urlParams.slice(0, -1)
    var url = "http://localhost/knowledgecity/api/" + urlParams;
    var response;
    $.ajax(
    {
      method:method,
      url:url,
      contentType: "application/json;",
      data:JSON.stringify(params),
      datatype:"json",
      async:false,
      success:function(res, status, xhttp){
        response = JSON.parse(res);
      }
    });
    return response;
}