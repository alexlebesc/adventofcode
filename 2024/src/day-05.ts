import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

/**
 * Satisfied with their search on Ceres,
 * the squadron of scholars suggests subsequently scanning the stationery stacks of sub-basement 17.
 *
 * The North Pole printing department is busier than ever this close to Christmas,
 * and while The Historians continue their search of this historically significant facility,
 * an Elf operating a very familiar printer beckons you over.
 *
 * The Elf must recognize you, because they waste no time explaining that the new sleigh launch safety manual updates won't print correctly.
 * Failure to update the safety manuals would be dire indeed, so you offer your services.
 *
 * Safety protocols clearly indicate that new pages for the safety manuals must be printed in a very specific order.
 * The notation X|Y means that if both page number X and page number Y are to be produced as part of an update,
 * page number X must be printed at some point before page number Y.
 *
 * The Elf has for you both the page ordering rules and the pages to produce in each update (your puzzle input),
 * but can't figure out whether each update has the pages in the right order.
 *
 * For example:
 *
 * 47|53
 * 97|13
 * 97|61
 * 97|47
 * 75|29
 * 61|13
 * 75|53
 * 29|13
 * 97|29
 * 53|29
 * 61|53
 * 97|53
 * 61|29
 * 47|13
 * 75|47
 * 97|75
 * 47|61
 * 75|61
 * 47|29
 * 75|13
 * 53|13
 *
 * 75,47,61,53,29
 * 97,61,53,29,13
 * 75,29,13
 * 75,97,47,61,53
 * 61,13,29
 * 97,13,75,29,47
 * The first section specifies the page ordering rules, one per line.
 * The first rule, 47|53, means that if an update includes both page number 47 and page number 53,
 * then page number 47 must be printed at some point before page number 53.
 * (47 doesn't necessarily need to be immediately before 53; other pages are allowed to be between them.)
 *
 * The second section specifies the page numbers of each update.
 * Because most safety manuals are different, the pages needed in the updates are different too.
 * The first update, 75,47,61,53,29, means that the update consists of page numbers 75, 47, 61, 53, and 29.
 *
 * To get the printers going as soon as possible, start by identifying which updates are already in the right order.
 *
 * In the above example, the first update (75,47,61,53,29) is in the right order:
 *
 * 75 is correctly first because there are rules that put each other page after it: 75|47, 75|61, 75|53, and 75|29.
 * 47 is correctly second because 75 must be before it (75|47)
 * and every other page must be after it according to 47|61, 47|53,
 * and 47|29.
 * 61 is correctly in the middle because 75 and 47 are before it (75|61 and 47|61)
 * and 53 and 29 are after it (61|53 and 61|29).
 * 53 is correctly fourth because it is before page number 29 (53|29).
 * 29 is the only page left and so is correctly last.
 * Because the first update does not include some page numbers,
 * the ordering rules involving those missing page numbers are ignored.
 *
 * The second and third updates are also in the correct order according to the rules.
 * Like the first update, they also do not include every page number,
 * and so only some of the ordering rules apply - within each update,
 * the ordering rules that involve missing page numbers are not used.
 *
 * The fourth update, 75,97,47,61,53, is not in the correct order:
 * it would print 75 before 97, which violates the rule 97|75.
 *
 * The fifth update, 61,13,29, is also not in the correct order, since it breaks the rule 29|13.
 *
 * The last update, 97,13,75,29,47, is not in the correct order due to breaking several rules.
 *
 * For some reason, the Elves also need to know the middle page number of each update being printed.
 * Because you are currently only printing the correctly-ordered updates,
 * you will need to find the middle page number of each correctly-ordered update.
 * In the above example, the correctly-ordered updates are:
 *
 * 75,47,61,53,29
 * 97,61,53,29,13
 * 75,29,13
 * These have middle page numbers of 61, 53, and 29 respectively. Adding these page numbers together gives 143.
 *
 * Of course, you'll need to be careful: the actual list of page ordering rules is bigger
 * and more complicated than the above example.
 *
 * Determine which updates are already in the correct order.
 * What do you get if you add up the middle page number from those correctly-ordered updates?
 */
class Day05 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_05.txt');
    private rules :number[][] = [];
    private updatePages : number[][] = [];

    private async initializeList(): Promise<boolean> {

        if (this.rules.length > 0) {
            return true;
        }

        return fs.readFile(this.filePath, 'utf8').then(data => {
            const lines :string[] = data.split('\n');
            const ruleRegex = /^[0-9]+\|[0-9]+$/
            lines.forEach((line) => {
                const isRule = line.match(ruleRegex);
                if (isRule) {
                    this.rules.push(line.split('|').map(Number));
                } else {
                    if (line.length == 0) {
                        return;
                    }

                    this.updatePages.push(line.split(',').map(Number));
                }
            });
            return true;
        });
    }

    private checkUpdateLineValid(updateLine :number[]) :boolean
    {
        return updateLine.every((updatePage, index, all) => {
            const restOfPages = all.toSpliced(0, index + 1);

            const rules = this.rules.filter((rule) => {
                const [, pageAfter] = rule;
                return (pageAfter === updatePage);
            });

            const before = rules.map((rule) => [...rule].shift());
            return restOfPages.every((page) => !before.includes(page))
        });
    }

    private fixWrongUpdateLine(updateLine :number[]): number[]
    {
        const UpdateLineFixed :number[] = [...updateLine];

        updateLine.forEach((currentPage, index, all) => {
            // find all number that should be present in front of the current page
            const pageInFrontOfCurrentPage = this.rules.filter((rule) => {
                const [, pageAfter] = rule;
                return (pageAfter === currentPage);
            })
            .map((rule) => [...rule].shift() ?? 0)
            .filter((page) => all.includes(page));

            // no page in front then do nothing
            if (pageInFrontOfCurrentPage.length === 0) {
                return;
            }

            // the page needs to be moved
            // first remove the page
            const indexToRemove = UpdateLineFixed.indexOf(currentPage);
            UpdateLineFixed.splice(indexToRemove, 1);

            // find where the page needs to be placed
            // just after all the page in front of the current page
            let moveToIndex = 0;
            pageInFrontOfCurrentPage.forEach((page)=> {
                const index = UpdateLineFixed.indexOf(page);
                moveToIndex = (index >= moveToIndex) ? index : moveToIndex
            });
            UpdateLineFixed.splice(moveToIndex + 1, 0, currentPage);
        });

        return UpdateLineFixed;
    }

    private middlePage(updateLine :Number[]) :number
    {
        const index = Math.ceil(updateLine.length/2) - 1;
        return updateLine[index].valueOf();
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la première étoile du jour 05
        return this.updatePages.filter((updateLine) => this.checkUpdateLineValid(updateLine)).reduce(
            (total, updateLine) => total + this.middlePage(updateLine), 0
        );
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la deuxième étoile du jour 05
        return this.updatePages.filter((updateLine) => !this.checkUpdateLineValid(updateLine))
            .map((updateLine) => this.fixWrongUpdateLine(updateLine))
            .reduce(
                (total, updateLine) => total + this.middlePage(updateLine), 0
            );
    }
}

(async () => {
    try {
        const day05:Day05 = new Day05();
        console.log('star1 :', await day05.resultStar1()) ;
        console.log('star2 :', await day05.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

