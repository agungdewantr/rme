import "./bootstrap";
import { Alpine, Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";
import "../../vendor/masmerise/livewire-toaster/resources/js";
import { mask } from "@alpinejs/mask";
Alpine.plugin(mask)


Livewire.start();
