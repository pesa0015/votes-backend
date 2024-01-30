const express = require("express");

const app = express(); 

app.use(
  express.urlencoded({
    extended: true
  })
)

app.use(express.json())

app.post('/', function(req, res){
    res.status(200).send().end()
})

app.listen(3000, function(){ 
  console.log("server is running on port 3000"); 
})