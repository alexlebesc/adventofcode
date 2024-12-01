import * as fs from 'fs';
import * as path from 'path';

// Chemin du fichier à lire
const filePath = path.join(__dirname, '../data/1/input.txt');

fs.readFile(filePath, 'utf8', (err, data) => {
    if (err) {
        console.error('Erreur lors de la lecture du fichier :', err);
        return;
    }

    const lines = data.split('\n');
    
    const list2: number[] = [];
    const list1 = lines.map((value, index) => {
        let values = value.split('   ');       
        list2[index] = Number(values.slice(-1));
        return Number(values.shift());
    });

    list1.sort();
    list2.sort();

    const total = list1.map((list1Value, index) => {
        let list2Value = list2[index];
        return Math.abs(list1Value - list2Value);
    }).reduce((acc, distance) => acc + distance);


    console.log('total :', total) ;

    const similarityScore = list1.map((list1Value, index) => {
        let similarity = list2.filter((list2Value) => list2Value === list1Value).length;
        return Math.abs(list1Value * similarity);
    }).reduce((acc, distance) => acc + distance);


    console.log('similarity:', similarityScore) ;
});


