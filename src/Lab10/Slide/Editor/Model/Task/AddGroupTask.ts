import {AbstractAddObjectTask} from "./AbstractAddObjectTask";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import {ObjectGroup} from "../Entity/ObjectGroup";

class AddGroupTask extends AbstractAddObjectTask {
    public constructor(
        items: Map<string, SlideComponentInterface>,
        private objectIds: string[],
    ) {
        super(items);
    }
    protected doExecute(): void {
        const values = this.objectIds.map(id => this.items.get(id)!);
        const group = new ObjectGroup(
            values,
        );
        this.storeObject(group);
    }

}

export {
    AddGroupTask
}
