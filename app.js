const express = require('express');
const axios = require('axios');
const app = express();

app.get('/proxy/products', async (req, res) => {
  try {
    const r = await axios.get('http://localhost/shop/api/get_products.php');
    res.json(r.data);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

app.listen(3000, ()=>console.log('Express running on 3000'));
