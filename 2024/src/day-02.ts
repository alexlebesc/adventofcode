import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

/**
 * The unusual data (your puzzle input) consists of many reports, one report per line. Each report is a list of numbers called levels that are separated by spaces. For example:
 *
 * 7 6 4 2 1
 * 1 2 7 8 9
 * 9 7 6 2 1
 * 1 3 2 4 5
 * 8 6 4 4 1
 * 1 3 6 7 9
 * This example data contains six reports each containing five levels.
 *
 * The engineers are trying to figure out which reports are safe.
 * The Red-Nosed reactor safety systems can only tolerate levels that are either gradually increasing or gradually decreasing.
 * So, a report only counts as safe if both of the following are true:
 *
 * The levels are either all increasing or all decreasing.
 * Any two adjacent levels differ by at least one and at most three.
 * In the example above, the reports can be found safe or unsafe by checking those rules:
 *
 * 7 6 4 2 1: Safe because the levels are all decreasing by 1 or 2.
 * 1 2 7 8 9: Unsafe because 2 7 is an increase of 5.
 * 9 7 6 2 1: Unsafe because 6 2 is a decrease of 4.
 * 1 3 2 4 5: Unsafe because 1 3 is increasing but 3 2 is decreasing.
 * 8 6 4 4 1: Unsafe because 4 4 is neither an increase or a decrease.
 * 1 3 6 7 9: Safe because the levels are all increasing by 1, 2, or 3.
 * So, in this example, 2 reports are safe.
 *
 * Analyze the unusual data from the engineers. How many reports are safe?
 *
 */
class Day02 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_02.txt');
    private reports :string[] = [];
    private safeReports :string[] = [];
    private unsafeReports :string[] = [];

    private async initializeList(): Promise<boolean> {

        return fs.readFile(this.filePath, 'utf8').then(data => {
            this.reports = data.split('\n');

            return true;
        });
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la première étoile du jour 02
        this.safeReports = this.reports.filter((report :string) :boolean => {
            const levels :number[] = report.split(' ').map((level :string) :number => Number(level));
            return this.checkReportSafeness(levels);
        });

        return this.safeReports.length;
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la deuxième étoile du jour 02 
        this.safeReports = this.reports.filter((report :string) :boolean => {
            const levels :number[] = report.split(' ').map((level :string) :number => Number(level));
            let safe = this.checkReportSafeness(levels);

            if (!safe) {
                levels.some((value, index, levels) => {
                    safe = this.checkReportSafeness(levels.toSpliced(index, 1));
                    return safe;
                });
            }

            return safe;
        });

        return this.safeReports.length;
    }

    private checkReportSafeness(levels :number[]) : boolean
    {
        let safe :boolean = false;

        if (
            levels.join() === levels.toSorted((a,b) => a - b).join() // tableau increase ?
            || levels.join() === levels.toSorted((a,b) => b - a).join() // tableau decrease ?
        ) {
            safe = true;

            levels.reduce((previousValue, currentValue) => {
                if (!safe) {
                    return currentValue;
                }

                let gap = Math.abs(previousValue - currentValue);
                if (!(gap >= 1 && gap <= 3 )) {
                    safe = false;
                }

                return currentValue
            });
        }

        return safe;
    }
}

(async () => {
    try {
        const day02:Day02 = new Day02();
        console.log('star1 :', await day02.resultStar1()) ;
        console.log('star2 :', await day02.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

