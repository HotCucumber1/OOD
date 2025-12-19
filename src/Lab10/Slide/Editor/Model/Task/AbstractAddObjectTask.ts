import {AbstractTask} from "../../../Common/History/AbstractTask";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";

abstract class AbstractAddObjectTask extends AbstractTask {
    protected id: string = '';

    protected constructor(
        protected items: Map<string, SlideComponentInterface>,
    ) {
        super();
    }

    protected abstract doExecute(): void;

    protected doUnexecute(): void {
        this.items.delete(this.id);
    }

    protected storeObject(object: SlideComponentInterface): string {
        const uuid = crypto.randomUUID();
        this.items.set(uuid, object);

        return uuid;
    }
}

export {
    AbstractAddObjectTask,
};
