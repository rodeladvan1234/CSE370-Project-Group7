//client side script.js
import { fetchReviews } from '../database.js';

fetchReviews(22101672)
    .then(result => {
        console.log('Reviews:', result);
    })
    .catch(error => {
        console.error('Error:', error);
    });
