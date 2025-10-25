<?php
declare(strict_types=1);

namespace Test\Unit\Editor;

use App\Lab5\Editor\Document\Data\ImageInterface;
use App\Lab5\Editor\Document\Data\ParagraphInterface;
use App\Lab5\Editor\Document\Document;
use App\Lab5\Editor\Document\DocumentInterface;
use App\Lab5\Editor\Document\Exception\InvalidItemIndexException;
use PHPUnit\Framework\TestCase;
use Test\Unit\Editor\Mock\MockImageSaveStrategy;

class DocumentTest extends TestCase
{
    private DocumentInterface $document;

    protected function setUp(): void
    {
        parent::setUp();
        $this->document = new Document(new MockImageSaveStrategy());
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function testInsertParagraphToEndSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $paragraph = $this->document->getItem(0);

        self::assertInstanceOf(ParagraphInterface::class, $paragraph);
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function testInsertParagraphInPositionSuccess(): void
    {
        $this->document->insertImage('data/image.jpg', 10, 10);
        $this->document->insertImage('data/image.jpg', 10, 10);
        $this->document->insertImage('data/image.jpg', 10, 10);

        $this->document->insertParagraph('ha-ha-ha-ha', 1);
        $paragraph = $this->document->getItem(1);
        $image = $this->document->getItem(2);
        $items = $this->document->listItems();

        self::assertInstanceOf(ParagraphInterface::class, $paragraph);
        self::assertInstanceOf(ImageInterface::class, $image);
        self::assertCount(4, $items);
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function testInsertImageToEndSuccess(): void
    {
        $this->document->insertImage('data/image.jpg', 10, 10);
        $paragraph = $this->document->getItem(0);

        self::assertInstanceOf(ImageInterface::class, $paragraph);
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function testInsertImageInPositionSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);

        $this->document->insertImage('data/image.jpg', 10, 10, 1);
        $image = $this->document->getItem(1);
        $paragraph = $this->document->getItem(2);
        $items = $this->document->listItems();

        self::assertInstanceOf(ParagraphInterface::class, $paragraph);
        self::assertInstanceOf(ImageInterface::class, $image);
        self::assertCount(4, $items);
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function testReplaceParagraphTextSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->replaceParagraphText(0, '12345Q');

        $paragraph = $this->document->getItem(0);
        self::assertEquals('12345Q', $paragraph->getText());
    }

    public function testReplaceParagraphTextInWrongPositionFail(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertImage('/path/new', 10, 10);

        $this->expectException(InvalidItemIndexException::class);
        $this->document->replaceParagraphText(1, '12345Q');
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function testResizeImageSuccess(): void
    {
        $this->document->insertImage('data/image.jpg', 10, 10);
        $this->document->resizeImage(0, 10, 10);

        $image = $this->document->getItem(0);
        self::assertEquals(10, $image->getWidth());
    }

    public function testResizeImageInWrongPositionFail(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertImage('/path/new', 10, 10);

        $this->expectException(InvalidItemIndexException::class);
        $this->document->resizeImage(0, 10, 10);
    }

    public function testGetItemsCountSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertImage('data/image.jpg', 10, 10, 1);

        $itemsCount = $this->document->getItemsCount();
        self::assertEquals(4, $itemsCount);
    }

    public function testListItemsSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertImage('data/image.jpg', 10, 10, 1);

        $items = $this->document->listItems();
        self::assertCount(4, $items);
    }

    public function testListEmptyItemsSuccess(): void
    {
        $items = $this->document->listItems();
        self::assertEmpty($items);
    }

    public function testDeleteItemSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertImage('data/image.jpg', 10, 10, 1);

        $this->document->deleteItem(2);
        $items = $this->document->listItems();
        self::assertCount(3, $items);
    }

    public function testDeleteWrongItemSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->insertImage('data/image.jpg', 10, 10, 1);

        $this->expectException(InvalidItemIndexException::class);
        $this->document->deleteItem(5);
    }

    public function testTitleSuccess(): void
    {
        $this->document->setTitle('ha-ha-ha-ha');
        $title = $this->document->getTitle();

        self::assertEquals('ha-ha-ha-ha', $title);
    }

    public function testCanUndoSuccess(): void
    {
        $canUndo = $this->document->canUndo();
        self::assertFalse($canUndo);

        $this->document->insertParagraph('ha-ha-ha-ha', null);

        $canUndo = $this->document->canUndo();
        self::assertTrue($canUndo);
    }

    public function testCanRedoSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $canRedo = $this->document->canRedo();
        self::assertFalse($canRedo);

        $this->document->undo();
        $canRedo = $this->document->canRedo();
        self::assertTrue($canRedo);
    }

    public function testUndoSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->undo();

        self::assertEmpty($this->document->listItems());
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function testUndoMergedSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);

        $this->document->replaceParagraphText(0, '1');
        $this->document->replaceParagraphText(0, '2');
        $this->document->undo();

        $paragraph = $this->document->getItem(0);
        self::assertEquals('ha-ha-ha-ha', $paragraph->getText());
    }

    public function testRedoSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);
        $this->document->undo();

        self::assertEmpty($this->document->listItems());

        $this->document->redo();
        self::assertNotEmpty($this->document->listItems());
    }

    /**
     * @throws InvalidItemIndexException
     */
    public function testRedoMergedSuccess(): void
    {
        $this->document->insertParagraph('ha-ha-ha-ha', null);

        $this->document->replaceParagraphText(0, '1');
        $this->document->replaceParagraphText(0, '2');
        $this->document->undo();

        $paragraph = $this->document->getItem(0);
        self::assertEquals('ha-ha-ha-ha', $paragraph->getText());

        $this->document->redo();
        $paragraph = $this->document->getItem(0);
        self::assertEquals('2', $paragraph->getText());
    }
}
