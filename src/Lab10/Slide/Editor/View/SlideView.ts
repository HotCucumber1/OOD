import type {SlideComponentInterface} from "../Model/Interface/SlideComponentInterface";
import {Frame, type Point} from "../../Common/Common";
import {Rectangle} from "../Model/Entity/Rectangle";
import {AbstractShape} from "../Model/Entity/AbstractShape";
import {Ellipse} from "../Model/Entity/Ellipse";
import {Triangle} from "../Model/Entity/Triangle";
import {Image} from "../Model/Entity/Image";

class SlideView {
    private WIDTH = 2000;
    private HEIGHT = 840;
    private BORDER_COLOR = '#00f';
    private RESIZE_HANDLE_SIZE = 8;

    private canvas: HTMLCanvasElement;
    private context: CanvasRenderingContext2D;

    private imageCache = new Map<string, HTMLImageElement>();
    private pendingImageLoads = new Map<string, Promise<HTMLImageElement>>();

    public constructor(canvasId: string) {
        const element = document.getElementById(canvasId);
        if (!element || !(element instanceof HTMLCanvasElement)) {
            throw new Error(`Canvas element with id "${canvasId}" not found`);
        }
        this.canvas = element;
        this.canvas.width = this.WIDTH;
        this.canvas.height = this.HEIGHT;

        const ctx = this.canvas.getContext('2d');
        if (!ctx) {
            throw new Error('Failed to get 2d context');
        }
        this.context = ctx;
    }

    public renderObjects(objects: SlideComponentInterface[]): void {
        this.context.clearRect(0, 0, this.WIDTH, this.HEIGHT);

        objects.forEach((object) => {
            if (object instanceof AbstractShape) {
                this.context.fillStyle = object.getColor().hex;
            }
            if (object instanceof Rectangle) {
                this.drawRect(object);
            }
            if (object instanceof Ellipse) {
                this.drawEllipse(object);
            }
            if (object instanceof Triangle) {
                this.drawTriangle(object);
            }
            if (object instanceof Image) {
                this.drawCachedImage(object);
            }
        });
    }

    public renderSelection(objects: SlideComponentInterface[]): void {
        objects.forEach(object => {
            this.drawHandleBorder(object);
        });
    }

    public onObjectClick(callback: (x: number, y: number) => void): void {
        this.canvas.addEventListener('click', (event) => {
            this.executeAction(event, callback);
        });
    }
    // TODO пропадает select у второй фигуры после ctrl + DND
    // TODO сделать так, чтобы фигуры при мультиселекете не уезжали за границу
    // TODO history на удаление группы объектов

    public onMouseDown(callback: (x: number, y: number) => void): void {
        this.canvas.addEventListener('mousedown', (event) => {
            this.executeAction(event, callback);
        });
        // TODO тут тоже селект и ловить на окне
    }

    public onMouseMove(callback: (x: number, y: number) => void): void {
        this.canvas.addEventListener('mousemove', (event) => {
            this.executeAction(event, callback);
        }); // TODO чекать, где клик, коммитт толкьо конечного состояния
    }

    public onMouseUp(callback: (x: number, y: number) => void): void {
        document.addEventListener('mouseup', (event) => {
            this.executeAction(event, callback);
        });
    }

    public onDeleteKeyDown(callback: () => void): void {
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Delete') {
                callback();
            }
        });
    }

    public onUndoKeyDown(callback: () => void): void {
        document.addEventListener('keypress', (event) => {
            if (event.ctrlKey && event.code === 'KeyZ' && !event.shiftKey) {
                event.preventDefault();
                callback();
            }
        });
    }

    public onRedoKeyDown(callback: () => void): void {
        document.addEventListener('keypress', (event) => {
            if (event.ctrlKey && event.shiftKey && event.code === 'KeyZ') {
                event.preventDefault();
                callback();
            }
        });
    }

    public onCollectKeyDown(callback: () => void): void {
        document.addEventListener('keydown', event => {
            if (event.code === 'ControlLeft') {
                callback();
            }
        });
    }

    public onCollectKeyUp(callback: () => void): void {
        document.addEventListener('keyup', event => {
            if (event.code === 'ControlLeft') {
                callback();
            }
        });
    }

    public getDefaultFrame(): Frame {
        const defaultWidth = 100;
        const defaultHeight = 100;

        return new Frame(
            this.canvas.width / 2 - defaultWidth / 2,
            this.canvas.height / 2 - defaultHeight / 2,
            this.canvas.width / 2 + defaultWidth / 2,
            this.canvas.height / 2 + defaultHeight / 2,
        );
    }

    private drawHandleBorder(object: SlideComponentInterface): void {
        const frame = object.getFrame();
        const topLeft = frame.getTopLeft();
        const bottomRight = frame.getBottomRight();
        const width = frame.getWidth();
        const height = frame.getHeight();

        this.context.strokeStyle = this.BORDER_COLOR;
        this.context.lineWidth = 2;
        this.context.strokeRect(
            topLeft.x,
            topLeft.y,
            width,
            height
        );

        const offset = (this.RESIZE_HANDLE_SIZE / 2);

        this.drawHandle(topLeft.x - offset, topLeft.y - offset);
        this.drawHandle(topLeft.x + width / 2 - offset, topLeft.y - offset);
        this.drawHandle(bottomRight.x - offset, topLeft.y - offset);

        this.drawHandle(topLeft.x - offset, topLeft.y + height / 2 - offset);
        this.drawHandle(bottomRight.x - offset, topLeft.y + height / 2 - offset);

        this.drawHandle(topLeft.x - offset, bottomRight.y - offset);
        this.drawHandle(topLeft.x + width / 2 - offset, bottomRight.y - offset);
        this.drawHandle(bottomRight.x - offset, bottomRight.y - offset);
    }

    private drawHandle(x: number, y: number): void {
        this.context.fillStyle = this.BORDER_COLOR;
        this.context.fillRect(x, y, this.RESIZE_HANDLE_SIZE, this.RESIZE_HANDLE_SIZE);
        this.context.strokeStyle = '#fff';
        this.context.lineWidth = 1;
        this.context.strokeRect(x, y, this.RESIZE_HANDLE_SIZE, this.RESIZE_HANDLE_SIZE);
    }

    private drawRect(rectangle: Rectangle): void {
        this.context.fillRect(
            rectangle.getFrame().getTopLeft().x,
            rectangle.getFrame().getTopLeft().y,
            rectangle.getFrame().getWidth(),
            rectangle.getFrame().getHeight(),
        );
    }

    private drawEllipse(ellipse: Ellipse): void {
        this.context.beginPath();
        this.context.ellipse(
            ellipse.getCenter().x,
            ellipse.getCenter().y,
            ellipse.getRadiusX(),
            ellipse.getRadiusY(),
            0, 0,
            2 * Math.PI,
        );
        this.context.fill();
    }

    private drawTriangle(triangle: Triangle): void {
        this.context.beginPath();
        triangle.getVertices().forEach((point, i) => {
            if (i === 0) {
                this.context.moveTo(point.x, point.y);
            } else {
                this.context.lineTo(point.x, point.y);
            }
        });
        this.context.closePath();
        this.context.fill();
    }

    private executeAction(event: PointerEvent | MouseEvent, callback: (x: number, y: number) => void): void {
        const point = this.getSlideCoords(event);
        callback(point.x, point.y);
    }


    private getSlideCoords(event: PointerEvent | MouseEvent): Point {
        const rect = this.canvas.getBoundingClientRect();

        return {
            x: event.clientX - rect.left,
            y: event.clientY - rect.top,
        };
    }

    private async drawCachedImage(image: Image): Promise<void> {
        const url = image.getImgPath();

        if (this.imageCache.has(url)) {
            const cachedImg = this.imageCache.get(url)!;
            this.drawImageToCanvas(cachedImg, image);
            return;
        }

        if (this.pendingImageLoads.has(url)) {
            try {
                const img = await this.pendingImageLoads.get(url)!;
                this.drawImageToCanvas(img, image);
            } catch (error) {
                console.error('Error loading pending image:', error);
            }
            return;
        }

        const loadPromise = this.loadImage(url);
        this.pendingImageLoads.set(url, loadPromise);

        try {
            const img = await loadPromise;
            this.imageCache.set(url, img);
            this.pendingImageLoads.delete(url);

            this.drawImageToCanvas(img, image);
        } catch (error) {
            console.error('Error loading image:', error);
            this.pendingImageLoads.delete(url);
        }
    }

    private drawImageToCanvas(img: HTMLImageElement, image: Image): void {
        const frame = image.getFrame();

        if (!img.complete || img.naturalWidth === 0) {
            return;
        }

        this.context.drawImage(
            img,
            frame.getTopLeft().x,
            frame.getTopLeft().y,
            frame.getWidth(),
            frame.getHeight(),
        );
    }

    private async loadImage(url: string): Promise<HTMLImageElement> {
        return new Promise((resolve, reject) => {
            const img = new window.Image();
            img.crossOrigin = 'anonymous';

            img.onload = () => resolve(img);
            img.onerror = () => reject(new Error(`Failed to load image: ${url}`));

            img.src = url;
        });
    }
}

export {
    SlideView,
};
