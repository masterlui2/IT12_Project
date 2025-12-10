<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceTemplate;
use App\Models\ServiceTemplateScope;
use App\Models\ServiceTemplateScopeCase;
use App\Models\ServiceTemplateWaiver;
use App\Models\ServiceTemplateWaiverCase;
use App\Models\ServiceTemplateDeliverable;

class ServiceTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Helper function for template creation
        $createTemplate = function ($name, $category, $description, $scopes, $waivers, $deliverables) {
            $template = ServiceTemplate::create([
                'name' => $name,
                'category' => $category,
                'description' => $description,
                'is_active' => true,
            ]);

            // Scopes + cases
            foreach ($scopes as $scopeData) {
                $scope = $template->scopes()->create([
                    'scenario_name' => $scopeData['scenario_name'],
                    'description' => $scopeData['description'],
                ]);
                foreach ($scopeData['cases'] as $case) {
                    $scope->cases()->create($case);
                }
            }

            // Waivers + cases
            foreach ($waivers as $waiverData) {
                $waiver = $template->waivers()->create([
                    'waiver_title' => $waiverData['waiver_title'],
                    'waiver_description' => $waiverData['waiver_description'],
                ]);
                foreach ($waiverData['cases'] as $case) {
                    $waiver->cases()->create($case);
                }
            }

            // Deliverables
            foreach ($deliverables as $deliverableDetail) {
                $template->deliverables()->create([
                    'deliverable_detail' => $deliverableDetail,
                ]);
            }
        };

        // -------------------------------------------------------
        // 1. LAPTOP REPAIR SERVICE
        // -------------------------------------------------------
        $createTemplate(
            'Laptop Repair Service',
            'Computer Repair',
            'Comprehensive service template covering laptop diagnostics, part replacement, and software optimization.',
            [
                [
                    'scenario_name' => 'Initial Laptop Diagnosis',
                    'description' => 'Test major components for hardware or software failure.',
                    'cases' => [
                        ['case_title' => 'Power Failure Check', 'case_description' => 'Inspect battery, charger, and power IC.'],
                        ['case_title' => 'Boot Issue Inspection', 'case_description' => 'Examine BIOS or OS boot loops.'],
                        ['case_title' => 'Display Assessment', 'case_description' => 'Identify flickering or dead pixels.'],
                        ['case_title' => 'Keyboard & Touchpad Test', 'case_description' => 'Check for unresponsive keys or cursor lag.'],
                        ['case_title' => 'Peripheral Port Check', 'case_description' => 'Test USB, HDMI, and audio ports.'],
                    ],
                ],
                [
                    'scenario_name' => 'Motherboard Repair and Rework',
                    'description' => 'Repair electronic faults and damaged components.',
                    'cases' => [
                        ['case_title' => 'Circuit Continuity Check', 'case_description' => 'Confirm line stability using diagnostic tools.'],
                        ['case_title' => 'Chip Reflow', 'case_description' => 'Resolder and reattach detached GPU/CPU chips.'],
                        ['case_title' => 'Component Replacement', 'case_description' => 'Replace ICs, resistors, and transistors.'],
                        ['case_title' => 'Short Circuit Removal', 'case_description' => 'Locate and eliminate electrical shorts.'],
                        ['case_title' => 'Voltage Regulation Test', 'case_description' => 'Verify voltage consistency from power ICs.'],
                    ],
                ],
            ],
            [
                [
                    'waiver_title' => 'Customer Acknowledgment of Service Limitations',
                    'waiver_description' => 'Defines scope of laptop repair coverage and exclusions.',
                    'cases' => [
                        ['case_title' => 'Pre-existing Issue Disclaimer', 'description' => 'Service provider not liable for old damages.'],
                        ['case_title' => 'Data Loss Disclaimer', 'description' => 'Customer responsible for data backups before repair.'],
                        ['case_title' => 'Battery Performance Variance', 'description' => 'Battery life may vary based on usage patterns.'],
                    ],
                ],
            ],
            [
                'Diagnostic report summarizing all detected problems',
                'Repaired hardware components with functional verification',
                'Updated OS and driver set installed',
                'User satisfaction approval before closure',
            ]
        );

        // -------------------------------------------------------
        // 2. PHONE & GADGET REPAIR SERVICE
        // -------------------------------------------------------
        $createTemplate(
            'Phone & Gadget Repair Service',
            'Electronics Repair',
            'Troubleshooting, repair, and optimization template for mobile devices and gadgets.',
            [
                [
                    'scenario_name' => 'Battery and Charging System Check',
                    'description' => 'Diagnose battery health and charging performance.',
                    'cases' => [
                        ['case_title' => 'Battery Test', 'case_description' => 'Check voltage and charge cycle count.'],
                        ['case_title' => 'Charging Port Replacement', 'case_description' => 'Repair or replace damaged ports.'],
                        ['case_title' => 'Power IC Test', 'case_description' => 'Verify stable current and output voltage.'],
                        ['case_title' => 'Button Functionality Check', 'case_description' => 'Ensure power and volume button responsiveness.'],
                        ['case_title' => 'Charging Calibration', 'case_description' => 'Adjust charging current thresholds.'],
                    ],
                ],
            ],
            [
                [
                    'waiver_title' => 'Limited Warranty and Customer Liability',
                    'waiver_description' => 'Defines limits of repair coverage on phone components.',
                    'cases' => [
                        ['case_title' => 'Moisture Damage Disclaimer', 'description' => 'Repairs exclude water-related damages.'],
                        ['case_title' => 'Third-party Tampering Policy', 'description' => 'Warranty void if device altered post-repair.'],
                    ],
                ],
            ],
            [
                'Functional gadget with verified charging and display performance',
                'Installed latest firmware and security patches',
            ]
        );

        // -------------------------------------------------------
        // 3. AC CLEANING AND REPAIR SERVICE
        // -------------------------------------------------------
        $createTemplate(
            'AC Cleaning and Repair Service',
            'Home Appliance Maintenance',
            'Template for full air conditioner servicing, deep cleaning, and cooling optimization.',
            [
                [
                    'scenario_name' => 'Filter Cleaning and Coil Maintenance',
                    'description' => 'Routine cleaning of key AC internals to enhance cooling efficiency.',
                    'cases' => [
                        ['case_title' => 'Filter Removal', 'case_description' => 'Detach and wash filters to remove dust buildup.'],
                        ['case_title' => 'Evaporator Coil Wash', 'case_description' => 'Remove grime and improve airflow.'],
                        ['case_title' => 'Drain Line Clearing', 'case_description' => 'Prevent overflow and leakage.'],
                        ['case_title' => 'Fan Cleaning', 'case_description' => 'Eliminate noise from dirt accumulation.'],
                        ['case_title' => 'Exterior Panel Wipe', 'case_description' => 'Clean outer casing for hygiene and appearance.'],
                    ],
                ],
            ],
            [
                [
                    'waiver_title' => 'Environmental and Usage Disclaimer',
                    'waiver_description' => 'Outlines customer care practices and external factors affecting AC performance.',
                    'cases' => [
                        ['case_title' => 'Improper Usage Liability', 'description' => 'Provider not liable for misuse after cleaning.'],
                        ['case_title' => 'Power Surge Damage Exclusion', 'description' => 'Electrical surge damages excluded.'],
                    ],
                ],
            ],
            [
                'Cleaned AC unit with optimized airflow',
                'Lubricated fan mechanisms',
                'Verified cooling efficiency levels',
            ]
        );

        // -------------------------------------------------------
        // 4. PRINTER SETUP AND REPAIR
        // -------------------------------------------------------
        $createTemplate(
            'Printer Setup and Repair',
            'Office Equipment Service',
            'Printer servicing covering setup, maintenance, and repairs.',
            [
                [
                    'scenario_name' => 'Scanner Motor Replacement',
                    'description' => 'Disassemble and replace scanner motor components.',
                    'cases' => [
                        ['case_title' => 'Motor Inspection', 'case_description' => 'Confirm mechanical faults and test new motor.'],
                        ['case_title' => 'Alignment Calibration', 'case_description' => 'Ensure precision of scanned documents.'],
                        ['case_title' => 'Lubrication of Moving Parts', 'case_description' => 'Prevent wear by proper lubrication.'],
                        ['case_title' => 'Connectivity Setup', 'case_description' => 'Reconfigure printer network connections.'],
                        ['case_title' => 'Software Update', 'case_description' => 'Install latest firmware for printer.'],
                    ],
                ],
            ],
            [
                [
                    'waiver_title' => 'Printer Maintenance Terms and Liability',
                    'waiver_description' => 'Defines printer servicing coverage and exclusions.',
                    'cases' => [
                        ['case_title' => 'Consumables Disclaimer', 'description' => 'Refills and toner excluded from warranty.'],
                        ['case_title' => 'Post-Service Usage Policy', 'description' => 'Customer must operate under standard usage guidelines.'],
                    ],
                ],
            ],
            [
                'Fully functional printer with verified connectivity',
                'Completed preventive maintenance and calibration',
            ]
        );

        // -------------------------------------------------------
        // 5. WASHING MACHINE REPAIR
        // -------------------------------------------------------
        $createTemplate(
            'Washing Machine Repair',
            'Home Appliance Repair',
            'Maintenance and technical repair of washer motors, drainage, and spin functions.',
            [
                [
                    'scenario_name' => 'Drum and Motor Servicing',
                    'description' => 'Inspect and balance drum rotation and replace defective motor parts.',
                    'cases' => [
                        ['case_title' => 'Motor Coil Resistance Test', 'case_description' => 'Diagnose faulty motor coils.'],
                        ['case_title' => 'Bearing Lubrication', 'case_description' => 'Lubricate drum bearings to avoid friction.'],
                        ['case_title' => 'Spin Balance Adjustment', 'case_description' => 'Calibrate to eliminate shaking.'],
                        ['case_title' => 'Belt Tightening', 'case_description' => 'Adjust tension for smooth function.'],
                        ['case_title' => 'Final Spin Test', 'case_description' => 'Verify performance through cycle test.'],
                    ],
                ],
            ],
            [
                [
                    'waiver_title' => 'Water Damage and Usage Disclaimer',
                    'waiver_description' => 'Addresses external conditions and misuse resulting in damage.',
                    'cases' => [
                        ['case_title' => 'External Water Leakage', 'description' => 'Provider not liable for plumbing-based leaks.'],
                        ['case_title' => 'Load Overcapacity', 'description' => 'Damage from extreme load excluded.'],
                    ],
                ],
            ],
            [
                'Restored washing machine with noise-free operation',
                'Lubricated and balanced drum rotation',
            ]
        );

        // -------------------------------------------------------
        // 6. DENTAL CLINIC TECHNOLOGY MAINTENANCE
        // -------------------------------------------------------
        $createTemplate(
            'Dental Clinic Technology Maintenance',
            'Medical Equipment Service',
            'Technical maintenance for dental equipment, chairs, and imaging devices.',
            [
                [
                    'scenario_name' => 'Dental Chair Calibration',
                    'description' => 'Electrical and safety calibration for dental chairs.',
                    'cases' => [
                        ['case_title' => 'Motor Response Check', 'case_description' => 'Test movement and alignment motors.'],
                        ['case_title' => 'Control Panel Repair', 'case_description' => 'Fix non-responsive console buttons.'],
                        ['case_title' => 'Power Supply Verification', 'case_description' => 'Check stability of power supply.'],
                        ['case_title' => 'Fuse Replacement', 'case_description' => 'Restore protective components.'],
                        ['case_title' => 'Safety Stop Testing', 'case_description' => 'Evaluate emergency circuit system.'],
                    ],
                ],
            ],
            [
                [
                    'waiver_title' => 'Medical Equipment Service Limitation',
                    'waiver_description' => 'Special disclaimers for sensitive medical equipment servicing.',
                    'cases' => [
                        ['case_title' => 'Operational Risk Disclaimer', 'description' => 'Minor calibration tolerance accepted.'],
                        ['case_title' => 'Manufacturer Warranty Exclusion', 'description' => 'Manufacturer warranty unaffected.'],
                    ],
                ],
            ],
            [
                'Calibrated dental equipment with final operation report',
                'Safety circuits verified and labeled',
            ]
        );
    }
}
