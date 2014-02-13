var dataUrl;
var saveUrl;
var removeUrl;
var updateUrl;

var hist = false;
var step = 0;
var maxStep = 0;
var minStep = 0;

function init(dUrl, sUrl, rUrl, uUrl)
{
    dataUrl = dUrl;
    saveUrl = sUrl;
    removeUrl = rUrl;
    updateUrl = uUrl;
    
    $(".button").button();
    
    $("#index").hide();
    
    $("#forward").hide();
    
    $("#backward").click(function(){
        console.log(step, minStep, maxStep);
        hist = true;
        if (step > minStep) {
            step--;
            refresh();
        }
        return false;
    });
    
    $("#forward").click(function(){
        console.log(step, minStep, maxStep);
        if (step < maxStep) {
            step++;
            refresh();
        }
    });

    refresh();
}

function check()
{
    $("#forward").hide();
    $("#backward").hide();
    if (step < maxStep) {
        $("#forward").show();
    }
    if (step > minStep) {
        $("#backward").show();
    }
}

function edit(id)
{
    $("#text").val($("#text-" + id).text());
    $("#item-id").val(id);
}

function save()
{
    if ($("#text").val().length > 0) {
        $.post(saveUrl, {id: $("#item-id").val(), text: $("#text").val()}, function(data){
            if (data.result == "success") {
                step = data.step;
                maxStep = data.maxstep;
                $("#item-id").val("");
                $("#text").val("");
                $("#backward").show();
                refresh();
            }
        }, "json");
    } else {
        alert("Введите текст");
    }
    return false;
}

function remove(id)
{
    if (confirm("Удалить?")) {
        $.post(removeUrl, {id: id}, function(data){
            if (data.result == "success") {
                step = data.step;
                maxStep = data.maxstep;
                refresh();
            }
        }, "json");
    }
}

function update()
{
    $.post(updateUrl, {data: $("#list").sortable("toArray", {attribute: "data-id"})}, function(data){
        if (data.result == "success") {
            step = data.step;
            maxStep = data.maxstep;
        }
    }, "json");
}

function refresh()
{
    $.post(dataUrl, {hist: hist ? 1 : 0, step: step}, function(data){
        if (data.data.length > 0) {
            step = data.step;
            maxStep = data.maxstep;
            $("#list").empty();
            for (var i in data.data) {
                var id = data.data[i].id;
                var text = data.data[i].text;
                var buttons = '<div style="float:right;"><a href="javascript:void(0);" class="edit" data-id="' + id + '">Редактировать</a>&nbsp/&nbsp;';
                buttons += '<a href="javascript:void(0);" class="remove" data-id="' + id + '">Удалить</a></div>';
                var div = '<span id="text-' + id + '">' + text + '</span>';
                if (!hist) {
                    div += buttons;
                }
                $("#list").append('<li class="ui-state-default" id="item-' + id + '" data-id="' + id + '"><span class="ui-icon ui-icon-arrowthick-2-n-s" style="float:left;"></span>' + div + '</li>');
            }
            
            $("#list").sortable({
                update: function() {
                    update();
                }
            });
            
            if (hist) {
                $("#list").sortable("disable");
                $("#index").show();
            }
            
            $(".edit").click(function(){
                edit($(this).attr("data-id"));
                return false;
            });
            
            $(".remove").click(function(){
                remove($(this).attr("data-id"));
                return false;
            });
            
            maxStep = data.maxstep;
            minStep = data.minstep;
            step = data.step;
            
            check();
        } else {
            $("#backward").hide();
        }
    }, "json");
}
