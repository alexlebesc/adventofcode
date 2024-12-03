import * as fs from 'fs';
import * as path from 'path';
import { Eta } from 'eta';

class FileGenerator {
    private dataDir: string;
    private srcDir: string;

    constructor(dataDir: string = 'data') {
        this.dataDir = path.join(__dirname, '../', dataDir);
        this.srcDir = path.join(__dirname, '../src');
        this.ensureDirectoryExists();
    }

    private ensureDirectoryExists(): void {
        if (!fs.existsSync(this.dataDir)) {
            fs.mkdirSync(this.dataDir, { recursive: true });
        }
    }

    public generateFiles(count: number = 24): void {
        // créer un fichier input.txt dans data pour chaque jour
        for (let i :number = 1; i <= count; i++) {
            const fileName :string = 'input_' + i.toString().padStart(2, '0') + '.txt';
            const filePath :string = path.join(this.dataDir, fileName);
            const content :string = 'This is the input file number' + i;

            try {
                fs.writeFileSync(filePath, content);
                console.log('Created file: ' + fileName);
            } catch (error) {
                console.error('Error creating file ' + fileName, error);
            }
        }
    }

    public generateClass(count: number = 24): void {
        const eta = new Eta({views: path.join(__dirname, "templates")});

        for (let i :number = 2; i <= count; i++) {
            const day = i.toString().padStart(2, '0'); 
            const fileName :string = 'day-' + day + '.ts';
            const filePath :string = path.join(this.srcDir, fileName);
            const content :string = eta.render("./class", { day: day })

            try {
                fs.writeFileSync(filePath, content);
                console.log('Created file: ' + fileName);
            } catch (error) {
                console.error('Error creating file ' + fileName, error);
            }
        }
    }
}

// créer une classe typescript qui embarque la logique métier star 1 et star 2
const generator = new FileGenerator();
//generator.generateFiles();
generator.generateClass();
