var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var mysql = require('mysql');
var PORT = process.env.PORT || 8080;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({
    extended: true
}));

// default route
app.get('/', function (req, res) {
    return res.send({ error: true, message: 'Test Web API' })
});


//qrcode
var db_config_qrcode = {
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'qrcode'
};


var connection_qrcode;

function handleDisconnect_qrcode() {
    connection_qrcode = mysql.createConnection(db_config_qrcode);

    connection_qrcode.connect(function (err) {             
        if (err) {                                    
            console.log('error when connecting to db:', err);
            setTimeout(handleDisconnect_qrcode, 2000);
        }                                  
    });                                    
   
    connection_qrcode.on('error', function (err) {
        console.log('db error', err);
        if (err.code === 'PROTOCOL_CONNECTION_LOST') { 
            handleDisconnect_qrcode();                       
        } else {                                     
            throw err;                                 
        }
    });
}

handleDisconnect_qrcode();

// Retrieve path
app.get('/path', function (req, res) {
    console.log("Retrieve path")
    connection_qrcode.query('SELECT * FROM path', function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});

// Retrieve point from path_id
app.get('/point/:path_id', function (req, res) {
    let path_id = req.params.path_id;
    console.log("Retrieve point from path_id " + path_id)
    connection_qrcode.query('SELECT * FROM point,path where point.path_id = path.path_id AND point.path_id = ?', [path_id], function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


// Retrieve qrcode
app.get('/qrcode/:point_id', function (req, res) {
    let point_id = req.params.point_id;
    console.log("Retrieve qrcode from point_id " + point_id)
    connection_qrcode.query('SELECT * FROM qrcode,point WHERE qrcode.point_id = point.point_id AND point.point_id = ? ORDER BY qrcode_id DESC LIMIT 1', [point_id], function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});

// Retrieve bird in point
app.get('/bird_in_point/:point_id', function (req, res) {
    let point_id = req.params.point_id;
    console.log("Retrieve qrcode private from point_id " + point_id)
    connection_qrcode.query('SELECT * FROM bird,point WHERE bird.point_id = point.point_id AND point.point_id = ?', [point_id], function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


//bird
var db_config = {
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'bird'
};


var connection;


function handleDisconnect() {
    connection = mysql.createConnection(db_config); // Recreate the connection, since
    // the old one cannot be reused.

    connection.connect(function (err) {              // The server is either down
        if (err) {                                     // or restarting (takes a while sometimes).
            console.log('error when connecting to db:', err);
            setTimeout(handleDisconnect, 2000); // We introduce a delay before attempting to reconnect,
        }                                     // to avoid a hot loop, and to allow our node script to
    });                                     // process asynchronous requests in the meantime.
    // If you're also serving http, display a 503 error.
    connection.on('error', function (err) {
        console.log('db error', err);
        if (err.code === 'PROTOCOL_CONNECTION_LOST') { // Connection to the MySQL server is usually
            handleDisconnect();                         // lost due to either server restart, or a
        } else {                                      // connnection idle timeout (the wait_timeout
            throw err;                                  // server variable configures this)
        }
    });
}

handleDisconnect();

// Retrieve bird family
app.get('/bird_family', function (req, res) {
    console.log("Retrieve bird_family")
    connection.query('SELECT * FROM bird_family', function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});

// Retrieve bird family from bird_family_name
app.get('/bird_family/:bird_family_name', function (req, res) {
    let bird_family_name = req.params.bird_family_name;
    console.log("Retrieve bird family from bird_family_name " + bird_family_name)
    if (!bird_family_name) {
        return res.status(400).send({ error: true, message: 'Please provide bird_family_name' });
    }
    connection.query("SELECT * FROM bird_family where bird_family_name LIKE '%' ? '%' ", [bird_family_name], function (error, results, fields) {
        if (error) {
            console.log(error)
            res.status(422).json({ "status": "failed" });
            res.end()
        } else {
            res.status(200).json(results);
            res.end()
        }
    });
});


// Retrieve bird_name
app.get('/birds', function (req, res) {
    connection.query("SELECT * FROM ((birds INNER JOIN bird_family ON birds.bird_family_id = bird_family.bird_family_id) INNER JOIN bird_pic ON bird_pic.bird_id = birds.bird_id)" , function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


// Retrieve birds
app.get('/birds/:bird_id', function (req, res) {
	let bird_id = JSON.parse(req.params.bird_id)
	console.log("Retrieve bird_id " + bird_id)
    connection.query("SELECT * FROM ((birds INNER JOIN bird_family ON birds.bird_family_id = bird_family.bird_family_id) INNER JOIN bird_pic ON bird_pic.bird_id = birds.bird_id) WHERE birds.bird_id IN (?)", [bird_id], function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


// Retrieve birds from bird_name
app.get('/bird_name/:bird_name', function (req, res) {
	let bird_name = req.params.bird_name;
	console.log("Retrieve bird_name " + bird_name)
    connection.query("SELECT * FROM birds LEFT JOIN bird_family ON birds.bird_family_id = bird_family.bird_family_id LEFT JOIN bird_pic ON birds.bird_id = bird_pic.bird_id WHERE birds.bird_name = ?", [bird_name], function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


// Retrieve birds from bird_family_id
app.get('/birds/bird_family_id/:bird_family_id', function (req, res) {
    let bird_family_id = req.params.bird_family_id;
    console.log("Retrieve birds from bird_family_id " + bird_family_id)
    if (!bird_family_id) {
        return res.status(400).send({ error: true, message: 'Please provide bird_family_id' });
    }
    connection.query("SELECT * FROM birds LEFT JOIN bird_family ON birds.bird_family_id = bird_family.bird_family_id LEFT JOIN bird_pic ON birds.bird_id = bird_pic.bird_id WHERE birds.bird_family_id = ? GROUP BY birds.bird_id", [bird_family_id], function (error, results, fields) {
        if (error) {
            console.log(error)
            res.status(422).json({ "status": "failed" });
            res.end()
        } else {
            res.status(200).json(results);
            res.end()
        }
    });
});

// Retrieve bird detail
app.get('/bird_detail/bird_id/:bird_id', function (req, res) {
    let bird_id = req.params.bird_id;
    console.log("Retrieve bird detail from bird_id " + bird_id)
    if (!bird_id) {
        return res.status(400).send({ error: true, message: 'Please provide bird_id' });
    }
    connection.query("SELECT * FROM birds,bird_pic,bird_family WHERE birds.bird_id = bird_pic.bird_id AND birds.bird_id = ? AND birds.bird_family_id = bird_family.bird_family_id", [bird_id], function (error, results, fields) {
        if (error) {
            console.log(error)
            res.status(422).json({ "status": "failed" });
            res.end()
        } else {
            res.status(200).json(results);
            res.end()
        }
    });
});


// Retrieve foundbird public
app.get('/foundbird_public', function (req, res) {
    console.log("Retrieve foundbird public")
    connection.query('SELECT * from foundbird,foundbird_pic,user WHERE foundbird.uid = user.uid AND foundbird.type = 1 AND foundbird.foundbird_id = foundbird_pic.foundbird_id GROUP BY foundbird.foundbird_id ORDER BY foundbird.foundbird_id DESC', function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


// Retrieve foundbird private
app.get('/foundbird_private/:uid', function (req, res) {
    let uid = req.params.uid;
    console.log("Retrieve foundbird private from uid" + uid)
    connection.query('SELECT * from foundbird,foundbird_pic,user WHERE foundbird.uid = ? AND user.uid = ? AND foundbird.type = 2 AND foundbird.foundbird_id = foundbird_pic.foundbird_id GROUP BY foundbird.foundbird_id ORDER BY foundbird.foundbird_id DESC', [uid, uid], function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


// Retrieve foundbird detail
app.get('/foundbird_detail/foundbird_id/:foundbird_id', function (req, res) {
	let foundbird_id = req.params.foundbird_id;
    console.log("Retrieve foundbird detail from foundbird_id" + foundbird_id)
    connection.query('SELECT * FROM foundbird,foundbird_pic,user WHERE foundbird.uid = user.uid AND foundbird.foundbird_id = foundbird_pic.foundbird_id AND foundbird.foundbird_id = ?', [foundbird_id] , function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});

//Insert foundbird
app.post('/insertfoundbird', function (req, res) {
    console.log("insert foundbird")
    var data = req.body
    if (!data) {
        return res.status(400).send({ error: true, message: 'failed insert foundbird' });
    }
    connection.query("INSERT INTO foundbird SET ? ", data, function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});

// Retrieve last foundbird id limit
app.get('/retrievelastfoundbirdid/:uid', function (req, res) {
	let uid = req.params.uid;
    console.log("Retrieve Last foundbird id")
    connection.query('SELECT foundbird_id FROM foundbird WHERE uid = ? ORDER BY foundbird_id DESC LIMIT 1' , [uid] , function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


//Insert foundbird pic
app.post('/insertfoundbirdpic', function (req, res) {
    console.log("insert foundbird pic")
    var data = req.body
    if (!data) {
        return res.status(400).send({ error: true, message: 'failed insert foundbird pic' });
    }
    connection.query("INSERT INTO foundbird_pic SET ? ", data, function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});

//Update foundbird
app.put('/updatefoundbird/:foundbird_id', function (req, res) {
    console.log("update_foundbird")
    let foundbird_id = req.params.foundbird_id;
    let data = req.body

    connection.query('UPDATE foundbird SET ? WHERE foundbird_id = ?',
        [data, foundbird_id], function (error, results, fields) {
            if (error) {
                console.log(error)
                res.status(422).json({ "status": "failed" });
                res.end()
            } else {
                res.status(200).json(results);
                res.end()
            }
        });
});

//Delete foundbird
app.delete('/deletefoundbird/:foundbird_id', function (req, res) {
    console.log("delete_foundbird")
    let foundbird_id = req.params.foundbird_id;

    if (!foundbird_id) {
        return res.status(400).send({ error: true, message: 'Please provide foundbird_id' });
    }

    connection.query('DELETE foundbird,foundbird_pic FROM foundbird LEFT JOIN foundbird_pic on foundbird.foundbird_id = foundbird_pic.foundbird_id WHERE foundbird.foundbird_id = ?', foundbird_id,

        function (error, results, fields) {

            if (error) throw error;
            return res.send({ error: false, data: results, message: 'Foundbird has been deleted successfully.' });
        });
});


// Retrieve user from uid
app.get('/user/uid/:uid', function (req, res) {
    let uid = req.params.uid;
    console.log("Retrieve user from uid " + uid)
    if (!uid) {
        return res.status(400).send({ error: true, message: 'Please provide uid' });
    }
    connection.query("SELECT * FROM user WHERE uid = ?", [uid], function (error, results, fields) {
        if (error) {
            console.log(error)
            res.status(422).json({ "status": "failed" });
            res.end()
        } else {
            res.status(200).json(results);
            res.end()
        }
    });
});

//register user
app.post('/register', function (req, res) {
    console.log("Register")
    var data = req.body
    if (!data) {
        return res.status(400).send({ error: true, message: 'Failed register' });
    }
    connection.query("INSERT INTO user SET ? ", data, function (error, results, fields) {
        if (error) throw error;
        return res.send(results);
    });
});


// set port
app.listen(PORT, () => {
    console.log('Node app is running on port', PORT);
});



module.exports = app;