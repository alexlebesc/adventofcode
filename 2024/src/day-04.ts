import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

/**
 * "Looks like the Chief's not here. Next!" One of The Historians pulls out a device and pushes the only button on it.
 * After a brief flash, you recognize the interior of the Ceres monitoring station!
 *
 * As the search for the Chief continues, a small Elf who lives on the station tugs on your shirt;
 * she'd like to know if you could help her with her word search (your puzzle input).
 * She only has to find one word: XMAS.
 *
 * This word search allows words to be horizontal, vertical, diagonal, written backwards, or even overlapping other words.
 * It's a little unusual, though, as you don't merely need to find one instance of XMAS - you need to find all of them.
 * Here are a few ways XMAS might appear, where irrelevant characters have been replaced with .:
 *
 *
 * ..X...
 * .SAMX.
 * .A..A.
 * XMAS.S
 * .X....
 * The actual word search will be full of letters instead. For example:
 *
 * MMMSXXMASM
 * MSAMXMSMSA
 * AMXSXMAAMM
 * MSAMASMSMX
 * XMASAMXAMM
 * XXAMMXXAMA
 * SMSMSASXSS
 * SAXAMASAAA
 * MAMMMXMMMM
 * MXMXAXMASX
 * In this word search, XMAS occurs a total of 18 times;
 * here's the same word search again, but where letters not involved in any XMAS have been replaced with .:
 *
 * ....XXMAS.
 * .SAMXMS...
 * ...S..A...
 * ..A.A.MS.X
 * XMASAMX.MM
 * X.....XA.A
 * S.S.S.S.SS
 * .A.A.A.A.A
 * ..M.M.M.MM
 * .X.X.XMASX
 * Take a look at the little Elf's word search. How many times does XMAS appear?
 */
class Day04 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_04.txt');
    private coordX :number[][] =[];
    private coordA :number[][] =[];
    private grid :string[][] =[];

    private async initializeList(): Promise<boolean> {
        if (this.coordA.length > 0) {
            return true;
        }

        return fs.readFile(this.filePath, 'utf8').then(data => {
            const lines :string[] = data.split('\n');

            lines.forEach((line, y) => {

                this.grid[y] = [];
                line.split('').forEach((letter, x) => {
                    if (letter.toUpperCase() === 'X') {
                        this.coordX.push([y, x]);
                    }

                    if (letter.toUpperCase() === 'A') {
                        this.coordA.push([y, x]);
                    }

                    if (['X', 'M', 'A', 'S'].includes(letter.toUpperCase())) {
                        this.grid[y][x] = letter.toUpperCase();
                    }                   
                });
            });
            return true;
        });
    }

    private detectVerticalTop2BottomXmas(xcoord :number[]): boolean
    {
        const [y, x] = xcoord;
        //    x
        const m :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x] && this.grid[y + 1][x] === 'M');
        const a :boolean = !!(this.grid[y + 2] && this.grid[y + 2][x] && this.grid[y + 2][x] === 'A');
        const s :boolean = !!(this.grid[y + 3] && this.grid[y + 3][x] && this.grid[y + 3][x] === 'S');
        return (m && a && s);
    }

    private detectVerticalBottom2TopXmas(xcoord :number[]): boolean
    {
        const [y, x] = xcoord;
        const s :boolean = !!(this.grid[y - 3] && this.grid[y - 3][x] && this.grid[y - 3][x] === 'S');
        const a :boolean = !!(this.grid[y - 2] && this.grid[y - 2][x] && this.grid[y - 2][x] === 'A');
        const m :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x] && this.grid[y - 1][x] === 'M');
        //    x

        return (m && a && s);
    }

    private detectHorizontalLeft2RightXmas(xcoord :number[]): boolean
    {
        const [y, x] = xcoord;
        //    x
        const m :boolean = !!(this.grid[y] && this.grid[y][x + 1] && this.grid[y][x + 1] === 'M');
        const a :boolean = !!(this.grid[y] && this.grid[y][x + 2] && this.grid[y][x + 2] === 'A');
        const s :boolean = !!(this.grid[y] && this.grid[y][x + 3] && this.grid[y][x + 3] === 'S');

        return (m && a && s);
    }

    private detectHorizontalRight2LeftXmas(xcoord :number[]): boolean
    {
        const [y, x] = xcoord;
        const s :boolean = !!(this.grid[y] && this.grid[y][x - 3] && this.grid[y][x - 3] === 'S');
        const a :boolean = !!(this.grid[y] && this.grid[y][x - 2] && this.grid[y][x - 2] === 'A');
        const m :boolean = !!(this.grid[y] && this.grid[y][x - 1] && this.grid[y][x - 1] === 'M');
        //    x

        return (m && a && s);
    }

    private detectDiagonalLeft2RightTop2BottomXmas(xcoord :number[]): boolean
    {
        const [y, x] = xcoord;
        //    x
        const m :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x + 1] && this.grid[y + 1][x + 1] === 'M');
        const a :boolean = !!(this.grid[y + 2] && this.grid[y + 2][x + 2] && this.grid[y + 2][x + 2] === 'A');
        const s :boolean = !!(this.grid[y + 3] && this.grid[y + 3][x + 3] && this.grid[y + 3][x + 3] === 'S');
        return (m && a && s);
    }

    private detectDiagonalLeft2RightBottom2TopXmas(xcoord :number[]): boolean
    {
        const [y, x] = xcoord;

        const s :boolean = !!(this.grid[y - 3] && this.grid[y - 3][x + 3] && this.grid[y - 3][x + 3] === 'S');
        const a :boolean = !!(this.grid[y - 2] && this.grid[y - 2][x + 2] && this.grid[y - 2][x + 2] === 'A');
        const m :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x + 1] && this.grid[y - 1][x + 1] === 'M');
        //    x

        return (m && a && s);
    }

    private detectDiagonalRight2LeftTop2BottomXmas(xcoord :number[]): boolean
    {
        const [y, x] = xcoord;
        //    x
        const m :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x - 1] && this.grid[y + 1][x - 1] === 'M');
        const a :boolean = !!(this.grid[y + 2] && this.grid[y + 2][x - 2] && this.grid[y + 2][x - 2] === 'A');
        const s :boolean = !!(this.grid[y + 3] && this.grid[y + 3][x - 3] && this.grid[y + 3][x - 3] === 'S');
        return (m && a && s);
    }

    private detectDiagonalRight2LeftBottom2TopXmas(xcoord :number[]): boolean
    {
        const [y, x] = xcoord;
        const s :boolean = !!(this.grid[y - 3] && this.grid[y - 3][x - 3] && this.grid[y - 3][x - 3] === 'S');
        const a :boolean = !!(this.grid[y - 2] && this.grid[y - 2][x - 2] && this.grid[y - 2][x - 2] === 'A');
        const m :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x - 1] && this.grid[y - 1][x - 1] === 'M');
        //    x

        return (m && a && s);
    }

    private detectXMasMSSM(acoord :number[]): boolean
    {
        const [y, x] = acoord;
        const m :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x - 1] && this.grid[y - 1][x - 1] === 'M');
        const s :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x + 1] && this.grid[y - 1][x + 1] === 'S');
        const s2 :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x + 1] && this.grid[y + 1][x + 1] === 'S');
        const m2 :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x - 1] && this.grid[y + 1][x - 1] === 'M');

        return (m && s && s2 && m2);
    }

    private detectXMasSSMM(acoord :number[]): boolean
    {
        const [y, x] = acoord;

        const s :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x - 1] && this.grid[y - 1][x - 1] === 'S');
        const s2 :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x + 1] && this.grid[y - 1][x + 1] === 'S');
        const m :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x + 1] && this.grid[y + 1][x + 1] === 'M');
        const m2 :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x - 1] && this.grid[y + 1][x - 1] === 'M');

        return (m && s && s2 && m2);
    }

    private detectXMasSMMS(acoord :number[]): boolean
    {
        const [y, x] = acoord;

        const s :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x - 1] && this.grid[y - 1][x - 1] === 'S');
        const m :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x + 1] && this.grid[y - 1][x + 1] === 'M');
        const m2 :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x + 1] && this.grid[y + 1][x + 1] === 'M');
        const s2 :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x - 1] && this.grid[y + 1][x - 1] === 'S');

        return (m && s && s2 && m2);
    }

    private detectXMasMMSS(acoord :number[]): boolean
    {
        const [y, x] = acoord;

        const m :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x - 1] && this.grid[y - 1][x - 1] === 'M');
        const m2 :boolean = !!(this.grid[y - 1] && this.grid[y - 1][x + 1] && this.grid[y - 1][x + 1] === 'M');
        const s :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x + 1] && this.grid[y + 1][x + 1] === 'S');
        const s2 :boolean = !!(this.grid[y + 1] && this.grid[y + 1][x - 1] && this.grid[y + 1][x - 1] === 'S');

        return (m && s && s2 && m2);
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();
        // Implémentation pour la première étoile du jour 04
        let totalXmas = 0;
        this.coordX.forEach((xcoord) => {
            totalXmas = (this.detectVerticalTop2BottomXmas(xcoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectVerticalBottom2TopXmas(xcoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectHorizontalLeft2RightXmas(xcoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectHorizontalRight2LeftXmas(xcoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectDiagonalLeft2RightTop2BottomXmas(xcoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectDiagonalRight2LeftTop2BottomXmas(xcoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectDiagonalLeft2RightBottom2TopXmas(xcoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectDiagonalRight2LeftBottom2TopXmas(xcoord)) ? totalXmas + 1 : totalXmas;
        });

        return totalXmas;
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la deuxième étoile du jour 04
        let totalXmas = 0;

        this.coordA.forEach((acoord) => {
            totalXmas = (this.detectXMasMSSM(acoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectXMasSSMM(acoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectXMasSMMS(acoord)) ? totalXmas + 1 : totalXmas;
            totalXmas = (this.detectXMasMMSS(acoord)) ? totalXmas + 1 : totalXmas;
        });

        return totalXmas;
    }
}

(async () => {
    try {
        const day04:Day04 = new Day04();
        console.log('star1 :', await day04.resultStar1()) ;
        console.log('star2 :', await day04.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

