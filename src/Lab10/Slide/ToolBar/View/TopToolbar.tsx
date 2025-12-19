import React from 'react';
import styles from './Toolbar.module.css';
import type {ToolbarViewProps} from "../Presenter/ToolBarPresenter";


function TopToolbar({
    tools,
    selectedTool,
    onToolSelect,
    onImageUpload,
    onAddShape,
}: ToolbarViewProps) {
    return (
        <header className={styles.toolbar}>
            <div className={styles.logo}>
                <span className={styles.logoIcon}>✎</span>
                <span className={styles.logoText}>Shape Editor</span>
            </div>

            <div className={styles.toolbarSection}>
                <div className={styles.sectionTitle}>Фигуры</div>
                <div className={styles.shapeButtons}>
                    {tools.map(shape => (
                        <button
                            key={shape.id}
                            className={`${styles.shapeButton} ${
                                selectedTool === shape.id ? styles.selected : ''
                            }`}
                            onClick={() => onToolSelect(shape.id)}
                            title={shape.name}
                            aria-label={`Выбрать ${shape.name}`}
                        >
                            <span className={styles.shapeIcon}>{shape.icon}</span>
                            <span className={styles.shapeName}>{shape.name}</span>
                        </button>
                    ))}
                </div>
            </div>

            <div className={styles.toolbarActions}>
                <button
                    className={styles.addButton}
                    onClick={onAddShape}
                    title="Добавить выбранную фигуру"
                    aria-label="Добавить фигуру"
                >
                    <span className={styles.addIcon}>+</span>
                    <span className={styles.addText}>Добавить фигуру</span>
                </button>

                <button
                    className={styles.imageButton}
                    onClick={onImageUpload}
                    title="Загрузить изображение"
                    aria-label="Загрузить изображение"
                >
                    <span className={styles.imageIcon}>🖼️</span>
                    <span className={styles.imageText}>Загрузить изображение</span>
                </button>
            </div>

            <div className={styles.toolbarStatus}>
                <div className={styles.statusDot}></div>
                <span className={styles.statusText}>
                    {selectedTool === 'rectangle' && 'Квадрат выбран'}
                    {selectedTool === 'circle' && 'Круг выбран'}
                    {selectedTool === 'ellipse' && 'Эллипс выбран'}
                    {selectedTool === 'image' && 'Готов к загрузке'}
                </span>
            </div>
        </header>
    );
}

export {
    TopToolbar,
};
