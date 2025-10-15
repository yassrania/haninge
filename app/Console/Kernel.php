protected function schedule(Schedule $schedule): void
{
    // مرة باليوم تكفي (أو شهريًا)
    $schedule->command('prayer:sync-mymasjid adb44a4b-9764-4ba9-b9a8-ccea499496b1 '.now()->year)->monthlyOn(1, '02:00');
    // تجهيز السنة القادمة في ديسمبر
    $schedule->command('prayer:sync-mymasjid adb44a4b-9764-4ba9-b9a8-ccea499496b1 '.now()->addYear()->year)
             ->yearlyOn(12, 15, '03:00');
}
protected function schedule(Schedule $schedule): void
{
    // مزامنة السنة الحالية شهريًا
    $schedule->command('prayer:sync-mymasjid adb44a4b-9764-4ba9-b9a8-ccea499496b1 '.now()->year)
             ->monthlyOn(1, '02:00');

    // حضّر السنة القادمة في ديسمبر
    $schedule->command('prayer:sync-mymasjid adb44a4b-9764-4ba9-b9a8-ccea499496b1 '.now()->addYear()->year)
             ->yearlyOn(12, 15, '03:00');
}

