<?php

namespace Database\Seeders;

use App\Models\DynamicPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DynamicPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert about us
        DynamicPage::updateOrCreate(['slug' => 'about-us'],
            [
                'title_ar' => 'Who Are We ?',
                'title_en' => 'Who Are We ?',
                'content_ar' => '<p>Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items.</p>
                                <p>Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and items.</p>
                                <p>With security and safety as our top priorities, make your transactions with confidence at any time.</p>',
                'content_en' => '<p>Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items.</p>
                                <p>Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and items.</p>
                                <p>With security and safety as our top priorities, make your transactions with confidence at any time.</p>',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'how-to-be-premium'],
            [
                'title_ar' => 'how ?',
                'title_en' => 'how ?',
                'content_ar' => '<p>Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items.</p>
                                <p>Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and items. With security and safety as our top priorities, make your transactions with confidence at any time.</p>',
                'content_en' => '<p>Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items.</p>
                                <p>Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and items. With security and safety as our top priorities, make your transactions with confidence at any time.</p>',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'privacy-policy'],
            [
                'title_ar' => 'privacy-policy',
                'title_en' => 'privacy-policy',
                'content_ar' => 'privacy-policy',
                'content_en' => 'privacy-policy',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'terms-and-conditions'],
            [
                'title_ar' => 'terms-and-conditions',
                'title_en' => 'terms-and-conditions',
                'content_ar' => 'terms-and-conditions',
                'content_en' => 'terms-and-conditions',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'selling-and-dealing-instructions'],
            [
                'title_ar' => 'what is the instruction ?',
                'title_en' => 'what is the instruction ?',
                'content_ar' => '<ul class="fw-600">
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                        </ul>',
                'content_en' => '<ul class="fw-600">
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                        </ul>',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'special-advertisement'],
            [
                'title_ar' => 'Featured “Pinned” Ads',
                'title_en' => 'Featured “Pinned” Ads',
                'content_ar' => '<p>It is a service that allows the merchant to place his advertisement in the section so that it appears distinctively, which leads to increased sales.</p>
                        <p class="fw-600 mb-0"><span class="text-primary mb-0">What is the installation cost?</span> What are the conditions for installing an ad? IInstall ads free service. Conditions for installing advertising are: </p>
                        <ul>
                            <li>You must have 20 positive reviews in the last year.</li>
                            <li>Item must have pictures and be in the correct section.</li>
                            <li>The item must be for the same merchant and not for someone else.</li>
                        </ul>',
                'content_en' => '<p>It is a service that allows the merchant to place his advertisement in the section so that it appears distinctively, which leads to increased sales.</p>
                        <p class="fw-600 mb-0"><span class="text-primary mb-0">What is the installation cost?</span> What are the conditions for installing an ad? IInstall ads free service. Conditions for installing advertising are: </p>
                        <ul>
                            <li>You must have 20 positive reviews in the last year.</li>
                            <li>Item must have pictures and be in the correct section.</li>
                            <li>The item must be for the same merchant and not for someone else.</li>
                        </ul>',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'payment-fees'],
            [
                'title_ar' => 'what is Payment fees ?',
                'title_en' => 'what is Payment fees ?',
                'content_ar' => '<ul class="fw-600">
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                        </ul>',
                'content_en' => '<ul class="fw-600">
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                            <li class="mb-2">Striving to meet your daily need, our website was designed to facilitates as a seller (wholesaler or retailer) or as buyer, selling or buying new or used items and goods. With capabilities of hosting and attending wide varieties of daily and weekly auctions for different items Spend less time. Make more money.With ease and shortcut the way of reaching your potential customers so you can sell and buy all kind of products and item With security and safety as our top priorities, make your transactions with confidence at any time.</li>
                        </ul>',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'safety-center'],
            [
                'title_ar' => 'Safety Center',
                'title_en' => 'Safety Center',
                'content_ar' => '<p><span class="text-primary">Striving to meet your daily need Protection from human exploitation (human trafficking, organ trafficking)</span>, We work on the Zahra platform with the Human Rights Commission in the Kingdom of Saudi Arabia https://www.hrc.gov.sa to combat human trafficking, protect the rights of migrant workers, provide the necessary technical, preventive and awareness resources, and assist victims of human trafficking. We do not accept the exploitation of the platform for any purposes that conflict with human rights regulations. Local and global human. The system in the Kingdom of Saudi Arabia prohibits - based on international and regional standards to combat trafficking crimes - all forms of trafficking in persons described in the Protocol to Prevent and Punish Trafficking in Human Beings, Especially Women and Children, supplementing the United Nations Convention against Transnational Organized Crime (Palerem Protocol). When we monitor content that violates human rights regulations, we do not hesitate to refer the content to the Human Rights Commission and suspend the membership of the violating user.</p>
                        <p class="mb-0"><span class="text-primary">How to report violating content</span> If you are a victim of human trafficking or view content that violates human rights regulations, you must immediately do the following:</p>
                        <ul class="mb-3">
                            <li>Report the ad published from within the ad page.</li>
                            <li>Report via (Contact Us). </li>
                            <li>Inform and communicate with the Human Rights Commission via email: Info@ncct.gov.sa</li>
                        </ul>
                        <p class="mb-0"><span class="text-primary">Protection from harassment or abuse (racism, hate and threats)</span>, The laws of the Kingdom of Saudi Arabia require all state agencies to do justice to people, regardless of their religion, race, gender or nationality, we at Haraj platform do not allow the user to practice any discrimination, threat, abuse, harm or bullying, whether in the published content or through private communication. If you are subjected to any abuse, you shall: If you are subjected to any abuse, you shall: -</p>
                        <ul class="mb-3">
                            <li>File a report via Contact Us. </li>
                            <li>File a complaint against the offending member of the security authorities.</li>
                        </ul>',
                'content_en' => '<p><span class="text-primary">Striving to meet your daily need Protection from human exploitation (human trafficking, organ trafficking)</span>, We work on the Zahra platform with the Human Rights Commission in the Kingdom of Saudi Arabia https://www.hrc.gov.sa to combat human trafficking, protect the rights of migrant workers, provide the necessary technical, preventive and awareness resources, and assist victims of human trafficking. We do not accept the exploitation of the platform for any purposes that conflict with human rights regulations. Local and global human. The system in the Kingdom of Saudi Arabia prohibits - based on international and regional standards to combat trafficking crimes - all forms of trafficking in persons described in the Protocol to Prevent and Punish Trafficking in Human Beings, Especially Women and Children, supplementing the United Nations Convention against Transnational Organized Crime (Palerem Protocol). When we monitor content that violates human rights regulations, we do not hesitate to refer the content to the Human Rights Commission and suspend the membership of the violating user.</p>
                        <p class="mb-0"><span class="text-primary">How to report violating content</span> If you are a victim of human trafficking or view content that violates human rights regulations, you must immediately do the following:</p>
                        <ul class="mb-3">
                            <li>Report the ad published from within the ad page.</li>
                            <li>Report via (Contact Us). </li>
                            <li>Inform and communicate with the Human Rights Commission via email: Info@ncct.gov.sa</li>
                        </ul>
                        <p class="mb-0"><span class="text-primary">Protection from harassment or abuse (racism, hate and threats)</span>, The laws of the Kingdom of Saudi Arabia require all state agencies to do justice to people, regardless of their religion, race, gender or nationality, we at Haraj platform do not allow the user to practice any discrimination, threat, abuse, harm or bullying, whether in the published content or through private communication. If you are subjected to any abuse, you shall: If you are subjected to any abuse, you shall: -</p>
                        <ul class="mb-3">
                            <li>File a report via Contact Us. </li>
                            <li>File a complaint against the offending member of the security authorities.</li>
                        </ul>',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'usage-agreement'],
            [
                'title_ar' => 'Introduction',
                'title_en' => 'Introduction',
                'content_ar' => '<p>This usage agreement, the privacy of use, the terms and conditions, and all the policies published on the Zahra platform were developed to protect and preserve the rights of both the Zahra Information Technology website organization and the user who accesses the site with or without registration or the consumer who benefits from the content with or without registration. .</p>
                        <p>Terms, conditions, conditions and legal disputes are subject to the laws, legislation and regulations in force in the Kingdom of Saudi Arabia.</p>
                        <p>As a user or consumer on the Haraj platform, you agree to abide by everything contained in this agreement once you use the platform, access it, or register for the service. The Haraj platform also has the right to amend this agreement at any time, and it is considered binding on all parties after announcing the update on the site or in any other means.</p>
                        <p class="text-primary fw-600 mb-0">Article one  : Definition  </p>
                        <ul class="fw-400">
                           <li><span class="fw-600">Zahra Platform:</span> It is an electronic platform that allows users to open an account to publish their content in accordance with regulations and legislation. Its headquarters is in Riyadh. It is referred to in this agreement as the Zahra  Information Technology Website Foundation (the owner of the Zahra Platform), or we, or us, or the site, or the platform, or the first party.</li>
                           <li><span class="fw-600">User:</span> is the creator of the account on the Zahra  platform for the purpose of communicating, browsing, publishing content, or to create an electronic store as a service provider for practicing e-commerce on the Zahra platform, and is referred to in this agreement as the member, practitioner, service provider, or second party.</li>
                           <li><span class="fw-600">Online store:</span> It is the electronic account that allows the user to display a product, sell it, provide a service, advertise it, or exchange data about it.</li>
                        </ul>
                        <p class="text-primary fw-600 mb-0">Article one  : Definition  </p>
                        <ul class="fw-400">
                           <li><span class="fw-600">Zahra Platform:</span> It is an electronic platform that allows users to open an account to publish their content in accordance with regulations and legislation. Its headquarters is in Riyadh. It is referred to in this agreement as the Zahra  Information Technology Website Foundation (the owner of the Zahra Platform), or we, or us, or the site, or the platform, or the first party.</li>
                           <li><span class="fw-600">User:</span> is the creator of the account on the Zahra  platform for the purpose of communicating, browsing, publishing content, or to create an electronic store as a service provider for practicing e-commerce on the Zahra platform, and is referred to in this agreement as the member, practitioner, service provider, or second party.</li>
                        </ul>',
                'content_en' => '<p>This usage agreement, the privacy of use, the terms and conditions, and all the policies published on the Zahra platform were developed to protect and preserve the rights of both the Zahra Information Technology website organization and the user who accesses the site with or without registration or the consumer who benefits from the content with or without registration. .</p>
                        <p>Terms, conditions, conditions and legal disputes are subject to the laws, legislation and regulations in force in the Kingdom of Saudi Arabia.</p>
                        <p>As a user or consumer on the Haraj platform, you agree to abide by everything contained in this agreement once you use the platform, access it, or register for the service. The Haraj platform also has the right to amend this agreement at any time, and it is considered binding on all parties after announcing the update on the site or in any other means.</p>
                        <p class="text-primary fw-600 mb-0">Article one  : Definition  </p>
                        <ul class="fw-400">
                           <li><span class="fw-600">Zahra Platform:</span> It is an electronic platform that allows users to open an account to publish their content in accordance with regulations and legislation. Its headquarters is in Riyadh. It is referred to in this agreement as the Zahra  Information Technology Website Foundation (the owner of the Zahra Platform), or we, or us, or the site, or the platform, or the first party.</li>
                           <li><span class="fw-600">User:</span> is the creator of the account on the Zahra  platform for the purpose of communicating, browsing, publishing content, or to create an electronic store as a service provider for practicing e-commerce on the Zahra platform, and is referred to in this agreement as the member, practitioner, service provider, or second party.</li>
                           <li><span class="fw-600">Online store:</span> It is the electronic account that allows the user to display a product, sell it, provide a service, advertise it, or exchange data about it.</li>
                        </ul>
                        <p class="text-primary fw-600 mb-0">Article one  : Definition  </p>
                        <ul class="fw-400">
                           <li><span class="fw-600">Zahra Platform:</span> It is an electronic platform that allows users to open an account to publish their content in accordance with regulations and legislation. Its headquarters is in Riyadh. It is referred to in this agreement as the Zahra  Information Technology Website Foundation (the owner of the Zahra Platform), or we, or us, or the site, or the platform, or the first party.</li>
                           <li><span class="fw-600">User:</span> is the creator of the account on the Zahra  platform for the purpose of communicating, browsing, publishing content, or to create an electronic store as a service provider for practicing e-commerce on the Zahra platform, and is referred to in this agreement as the member, practitioner, service provider, or second party.</li>
                        </ul>',
            ]);

        DynamicPage::updateOrCreate(['slug' => 'prohibited-advertisements'],
            [
                'title_ar' => 'Banned advertisements',
                'title_en' => 'Banned advertisements',
                'content_ar' => '<p>The following list contains most of the methods and methods of advertising prohibited on the site:</p>
                        <ul>
                            <li>All advertisements that are not related to buying and selling</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>All advertisements that are not related to buying and selling</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>All advertisements that are not related to buying and selling</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                        </ul>',
                'content_en' => '<p>The following list contains most of the methods and methods of advertising prohibited on the site:</p>
                        <ul>
                            <li>All advertisements that are not related to buying and selling</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>All advertisements that are not related to buying and selling</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>All advertisements that are not related to buying and selling</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertisements are intended for buying and selling only.</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                            <li>Advertising is for the purpose of adding a suggestion or discussing a problem with the administration on the site</li>
                        </ul>',
            ]);
    }
}
