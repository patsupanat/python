<!DOCTYPE html>
<html>

<head></head>

<body>

    <input type="file" class="js-fileElem" multiple accept="image/*" style="display:none">
    <a href="#" class="js-fileSelect">Select some files</a>

    <script src="https://www.gstatic.com/firebasejs/3.8.0/firebase.js"></script>
    <script>
        (() => { // protect the lemmings!
            // Initialize Firebase
            const config = {
                apiKey: "AIzaSyB3PbGDE1W9aagCXn8B9RdQJZKGH2mk_XI",
                authDomain: "python-c0103.firebaseapp.com",
                databaseURL: "https://python-c0103.firebaseio.com",
                projectId: "python-c0103",
                storageBucket: "python-c0103.appspot.com",
                messagingSenderId: "713551692093",
                appId: "1:713551692093:web:c20581fb55b67fd5"
            };
            firebase.initializeApp(config);

            // Get a reference to the storage service, which is used to create references in your storage bucket
            const storage = firebase.storage();
            // Create a storage reference from our storage service
            const storageRef = storage.ref();

            // Create a child reference
            const imagesRef = storageRef.child('python');
            // imagesRef now points to 'images'
            // Create a ref to a file - space.jpg
            const spaceRef = imagesRef.child('43.jpg');
            // ^^^ now you should have a "path" in your firebase storage that looks like: 'images/space.jpg'
            // select anchor tag and file input
            const fileSelect = document.querySelector('.js-fileSelect');
            const fileElem = document.querySelector('.js-fileElem');
            // click handler for fileElem
            fileSelect.addEventListener('click', (e) => {
                e.preventDefault();
                // trigger click on input type="file"
                // this will call the change event defined below
                if (fileElem) {
                    fileElem.click();
                }
            });
            // change handler for fileSelect
            fileElem.addEventListener('change', (e) => {
                // e.target.files contains File object references
                // to all chosen items by user
                console.log(e.target.files);
                /* ADDED THESE LINES */
                // since e.target.files is "array-like", we turn it into an array
                // then map it to the .put() method from Firebase, which returns promises...
                const fileUploads = Array.from(e.target.files).map((currFile) => {
                    // we store the name of the file as a storage ref
                    const fileRef = imagesRef.child(currFile.name);
                    // we return a promise where we first "put" or upload the file
                    // and then once the upload is complete, we return promise with
                    // download URL string of the file we uploaded
                    return fileRef.put(currFile).then((snapshot) => snapshot.downloadURL);
                });
                // once ALL the promises have been resolved
                // we console.log the urls...but we can do whatever we need to with this data 
                // from here
                Promise.all(fileUploads).then((items) => {
                    console.log(items);
                });
                /* END ADDED THESE LINES */
            });
        })();
    </script>
</body>

</html>