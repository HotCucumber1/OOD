import {
    useEffect,
    useRef,
    useState,
} from "react";
import styles from './style/App.module.css';
import {DocumentModel} from "./Editor/Model/Entity/DocumentModel";
import {AppPresenter} from "./AppPresenter";
import {TopToolbar} from "./ToolBar/View/TopToolbar";
import type {ToolbarViewProps} from "./ToolBar/Presenter/ToolBarPresenter";

type AppProps = {
    model: DocumentModel,
    canvasId: string,
}

function App({
                 model,
                 canvasId,
             }: AppProps) {

    const canvasRef = useRef<HTMLCanvasElement>(null);
    const presenterRef = useRef<AppPresenter>(null);

    const [toolbarProps, setToolbarProps] = useState<ToolbarViewProps>({
        tools: [],
        selectedTool: '',
        onToolSelect: () => {
        },
        onImageUpload: () => {
        },
        onAddShape: () => {
        }
    });

    const [shapeColor, setShapeColor] = useState('#FF603D');

    useEffect(() => {
        if (canvasRef.current && !presenterRef.current) {
            presenterRef.current = new AppPresenter(
                model,
                canvasId,
                (props) => setToolbarProps(props.toolbarProps),
                {hex: shapeColor},
            );

            return () => {
                presenterRef.current?.destroy();
            };
        }
    }, []);

    return (
        <div className={styles.app}>
            <TopToolbar
                {...toolbarProps}
                selectedColor={shapeColor}
                onColorChange={setShapeColor}
            />

            <main className={styles.mainContent}>
                <div className={styles.canvasContainer}>
                    <canvas
                        id={canvasId}
                        ref={canvasRef}
                        className={styles.canvas}
                    />
                </div>
            </main>
        </div>
    );
}

export {
    App,
    type AppProps,
};
