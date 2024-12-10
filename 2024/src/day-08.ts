import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

class Day08 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_08.txt');
    private grid :string[][] = [];
    private maxY = 0;
    private maxX = 0;
    private frequencies :Map<string, number[][]>;

    constructor() {
        this.frequencies = new Map<string, number[][]>();
    }
    private async initializeList(): Promise<boolean> {
        if (this.maxY > 0 ) {
            return true;
        }

        return fs.readFile(this.filePath, 'utf8').then(data => {
            const lines :string[] = data.split('\n');
            this.maxY = lines.length;
            this.maxX = lines[0].length;

            lines.forEach((line, y) => {
                this.grid[y] = [];
                line.split('').forEach((frequency :string, x) => {
                    if (!['.'].includes(frequency)) {
                        this.grid[y][x] = frequency;
                        const frequencyCoords = this.frequencies.get(frequency) ?? [];
                        frequencyCoords.push([y, x]);
                        this.frequencies.set(frequency, frequencyCoords);
                    }
                });
            });
            return true;
        });
    }

    private detectAntinodes(
        antinodes :Set<string>,
        mode :(a :number[], b :number[], maxY :number, maxX :number, antinodes :Set<string>) => void): void
    {
        // pour chaque frequency
        for ( const frequency of this.frequencies.keys()) {
            // determiner tous les segments
            const segments = new Set<number[][]>();
            const frequencyCoords = this.frequencies.get(frequency);
            frequencyCoords?.forEach((a, index, all) => {
                all.forEach((b) => {
                    if (a!== b) {
                        segments.add([a, b]);
                    }
                });
            })


            // pour chaque segment
            // déterminer le rectangle
            segments.forEach((ab) => {
                const [a, b] = ab;
                mode(a,b, this.maxY, this.maxX, antinodes);
            })
        }
    }

    private classicAntinodes(
        a :number[],
        b :number[],
        maxY :number,
        maxX :number,
        antinodes :Set<string>
    ) {
        let [ya, xa] = a;
        let [yb, xb] = b;
        let xaa = 0;
        let yaa = 0;
        let xab = 0;
        let yab = 0;

        const largeur = xa - xb;
        const hauteur = ya - yb;

        // if largeur est positive
        if (largeur > 0) {
            // A est à droite de B
            // Antipode de A est une largeur à droite de A
            xaa = xa + Math.abs(largeur);
            // Antipode de B est une largeur à gauche de B
            xab = xb - Math.abs(largeur);
        }

        // if largeur est négative
        if (largeur < 0) {
            // A est à gauche de B
            // Antipode de A est une largeur à gauche de A
            xaa = xa - Math.abs(largeur);
            // Antipode de B est une largeur à droite de B
            xab = xb + Math.abs(largeur);
        }

        // if hauteur est négative
        if (hauteur < 0) {
            // A est plus haut que B
            // Antipode de A est une hauteur en haut de A
            yaa = ya - Math.abs(hauteur);
            // Antipode de B est une hauteur en bas de B
            yab = yb + Math.abs(hauteur);
        }

        // if hauteur est positive
        if (hauteur > 0) {
            // A est plus bas que B
            // Antipode de A est une hauteur en bas de A
            yaa = ya + Math.abs(hauteur);
            // Antipode de B est une hauteur en haut de B
            yab = yb - Math.abs(hauteur);
        }

        if (yaa >= 0
            && yaa <  maxY
            && xaa >= 0
            && xaa < maxX
        ) {
            antinodes.add(yaa+'-'+xaa);
        }

        if (yab >= 0
            && yab <  maxY
            && xab >= 0
            && xab < maxX
        ) {
            antinodes.add(yab+'-'+xab);
        }
    }

    private harmonicAntinodes(
        a :number[],
        b :number[],
        maxY :number,
        maxX :number,
        antinodes :Set<string>
    ) {
        let [ya, xa] = a;
        let [yb, xb] = b;
        let xaa = 0;
        let yaa = 0;
        let xab = 0;
        let yab = 0;

        const largeur = xa - xb;
        const hauteur = ya - yb;

        let antinodeAExit = false;
        let antinodeBExit = false;

        antinodes.add(ya+'-'+xa);
        antinodes.add(yb+'-'+xb);

        while(!antinodeAExit || !antinodeBExit) {

            // if largeur est positive
            if (largeur > 0) {
                // A est à droite de B
                // Antipode de A est une largeur à droite de A
                xaa = xa + Math.abs(largeur);
                // Antipode de B est une largeur à gauche de B
                xab = xb - Math.abs(largeur);
            }

            // if largeur est négative
            if (largeur < 0) {
                // A est à gauche de B
                // Antipode de A est une largeur à gauche de A
                xaa = xa - Math.abs(largeur);
                // Antipode de B est une largeur à droite de B
                xab = xb + Math.abs(largeur);
            }

            // if hauteur est négative
            if (hauteur < 0) {
                // A est plus haut que B
                // Antipode de A est une hauteur en haut de A
                yaa = ya - Math.abs(hauteur);
                // Antipode de B est une hauteur en bas de B
                yab = yb + Math.abs(hauteur);
            }

            // if hauteur est positive
            if (hauteur > 0) {
                // A est plus bas que B
                // Antipode de A est une hauteur en bas de A
                yaa = ya + Math.abs(hauteur);
                // Antipode de B est une hauteur en haut de B
                yab = yb - Math.abs(hauteur);
            }

            if (yaa >= 0
                && yaa <  maxY
                && xaa >= 0
                && xaa < maxX
            ) {
                antinodes.add(yaa+'-'+xaa);
            } else {
                antinodeAExit = true;
            }

            if (yab >= 0
                && yab <  maxY
                && xab >= 0
                && xab < maxX
            ) {
                antinodes.add(yab+'-'+xab);
            } else {
                antinodeBExit = true;
            }

            ya = yaa;
            xa = xaa;

            yb = yab;
            xb = xab;
        }

    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la première étoile du jour 08
        const antinodes = new Set<string>();
        this.detectAntinodes(antinodes, this.classicAntinodes);
        // this.displayGrid(antinodes);
        return antinodes.size;
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();
        // Implémentation pour la deuxième étoile du jour 08

        const antinodes = new Set<string>();
        this.detectAntinodes(antinodes, this.harmonicAntinodes);
        // this.displayGrid(antinodes);
        return antinodes.size;
    }

    public async displayGrid(antinodes :Set<string>): Promise<boolean> {
        await this.initializeList();

        for(let y = 0; y < this.maxY; y ++) {
            let row = '';
            for(let x = 0; x < this.maxX; x ++) {
                let cell = this.grid[y][x] ?? '.';
                if (antinodes.has(y+'-'+x)) {
                    cell = '#';
                }
                row = row.concat(cell);
            }

            console.log(row);
        }

        return true;
    }
}

(async () => {
    try {
        const day08:Day08 = new Day08();
        console.log('star1 :', await day08.resultStar1()) ;
        console.log('star2 :', await day08.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

