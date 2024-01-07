$(function() {
    $('.modal').modal();


function getQueryStrings() {
    let queryStrings = window.location.search.substring(1).split("&") || [];
    let vars = {},hash;
    queryStrings.forEach(query => {
        hash = query.split("=");
        vars[hash[0]] = hash[1];
    });
    return vars;

}
const queryParams = getQueryStrings();
const operation = queryParams.op;
const statuss = queryParams.status;
if(operation && operation == "insert") {
    if(statuss == "success") {
        M.toast({html:'Contact Added Successfully',classes:'green darken-1'})
    }
}

});

