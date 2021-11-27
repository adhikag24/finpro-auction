import {
    initializeApp
} from "https://www.gstatic.com/firebasejs/9.5.0/firebase-app.js";

import {
    getDatabase,
    ref,
    onValue
} from "https://cdnjs.cloudflare.com/ajax/libs/firebase/9.5.0/firebase-database.min.js"

const firebaseConfig = {
    apiKey: "AIzaSyBaa2UTw3pZJqGf2XLolPinZZ-SeL7fctA",
    authDomain: "auction-website-1cc67.firebaseapp.com",
    databaseURL: "https://auction-website-1cc67-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "auction-website-1cc67",
    storageBucket: "auction-website-1cc67.appspot.com",
    messagingSenderId: "915777520945",
    appId: "1:915777520945:web:0fdd3a7b50a5e0c72adc10",
    measurementId: "G-E0QFPX769C"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

//create firebase database reference
const database = getDatabase(app);

//load older conatcts as well as any newly added one...
const productRef = ref(database, 'products/');

export{
    productRef,
    onValue,
}
