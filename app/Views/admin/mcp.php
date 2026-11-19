<?php require APPROOT . '/Views/admin/header.php'; ?>

<div class="admin-header" style="margin-bottom: 25px;">
    <div>
        <h1 class="text-premium-glow" style="font-family: 'Hind Siliguri', sans-serif; font-size: 1.8rem; margin: 0 0 6px;">
            <i class="fas fa-network-wired" style="color: #6366f1; font-size: 1.8rem; vertical-align: middle;"></i> Model Context Protocol (MCP) Server & API
        </h1>
        <p style="margin: 0; color: #64748b; font-size: 0.95rem;">
            আপনার ওয়েবসাইটকে Antigravity, Claude, Cursor বা যেকোনো AI এজেন্টের সাথে সরাসরি সংযুক্ত করুন। এআই স্বয়ংক্রিয়ভাবে পোস্ট সার্চ করতে পারবে, ডক ফাইল আপলোড ও প্রকাশ করতে পারবে এবং ক্যাটাগরি পরিচালনা করতে পারবে।
        </p>
    </div>
</div>

<?php if (!empty($data['success'])): ?>
    <div class="alert alert-success" style="background: #dcfce7; color: #166534; border: 1px solid #86efac; border-radius: 12px; padding: 14px 20px; margin-bottom: 25px; font-weight: 600;">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($data['success']) ?>
    </div>
<?php endif; ?>

<!-- Quick Status & Metric Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 25px;">
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">সার্ভার স্ট্যাটাস</span>
            <span style="background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;">
                <span style="width: 7px; height: 7px; background: #22c55e; border-radius: 50%; display: inline-block;"></span> Active
            </span>
        </div>
        <div style="font-size: 1.3rem; font-weight: 800; color: #0f172a;">JSON-RPC 2.0 & REST</div>
        <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">Bearer Token অথেনটিকেশন</div>
    </div>

    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">মোট পোস্ট</span>
            <i class="fas fa-newspaper" style="color: #3b82f6; font-size: 1.2rem;"></i>
        </div>
        <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;"><?= number_format($data['stats']['total_posts']) ?></div>
        <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">সার্চ ও পড়ার জন্য প্রস্তুত</div>
    </div>

    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">মোট ক্যাটাগরি</span>
            <i class="fas fa-folder-tree" style="color: #f59e0b; font-size: 1.2rem;"></i>
        </div>
        <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;"><?= number_format($data['stats']['total_categories']) ?></div>
        <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">অটো-প্যারেন্টিং সাপোর্টসহ</div>
    </div>

    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">প্রশ্ন ও উত্তর</span>
            <i class="fas fa-question-circle" style="color: #10b981; font-size: 1.2rem;"></i>
        </div>
        <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;"><?= number_format($data['stats']['total_questions']) ?></div>
        <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">সরাসরি উত্তর প্রদানযোগ্য</div>
    </div>
</div>

<!-- API Key & Connection Banner -->
<div style="background: linear-gradient(135deg, #f8faff 0%, #eef2ff 100%); border: 2px solid #c7d2fe; border-radius: 18px; padding: 26px; margin-bottom: 30px; box-shadow: 0 10px 25px rgba(99, 102, 241, 0.08);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
        <div style="max-width: 720px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #4f46e5; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">
                <i class="fas fa-plug"></i> AI Agent Connection Credentials
            </div>
            <h3 style="margin: 0 0 8px; color: #1e1b4b; font-size: 1.35rem; font-weight: 800; font-family: 'Hind Siliguri', sans-serif;">
                MCP সার্ভার সংযোগ ক্রেডেনশিয়াল ও কী (API Key)
            </h3>
            <p style="margin: 0; color: #4338ca; font-size: 0.95rem; line-height: 1.55;">
                আপনার AI অ্যাসিস্ট্যান্টকে এই ক্রেডেনশিয়াল প্রদান করলে সে স্বয়ংক্রিয়ভাবে সাইটের পোস্ট সার্চ করতে পারবে, ডক বা আর্টিকেল প্রকাশ করতে পারবে এবং প্রশ্নোত্তরের জবাব দিতে পারবে।
            </p>
        </div>
        <form action="<?= URLROOT ?>/admin/mcp" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে নতুন API কী তৈরি করতে চান? পুরনো কী দিয়ে সংযুক্ত কোনো এজেন্ট থাকলে তা পুনরায় কনফিগার করতে হবে।');">
            <?= csrf_field() ?>
            <input type="hidden" name="regenerate_key" value="1">
            <button type="submit" class="btn" style="background: #ffffff; color: #4338ca; border: 1.5px solid #818cf8; padding: 10px 18px; border-radius: 12px; font-weight: 700; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: 0.2s;">
                <i class="fas fa-sync-alt"></i> কী রি-জেনারেট করুন
            </button>
        </form>
    </div>

    <!-- Credentials Fields -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 16px;">
        <!-- Endpoint URL -->
        <div style="background: white; border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px 18px;">
            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">
                <i class="fas fa-globe"></i> MCP API Endpoint URL
            </label>
            <div style="display: flex; gap: 8px;">
                <input type="text" id="mcp_endpoint_input" value="<?= htmlspecialchars($data['api_endpoint']) ?>" readonly style="flex-grow: 1; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 8px; padding: 8px 12px; font-family: monospace; font-size: 0.9rem; color: #0f172a;">
                <button type="button" onclick="copyText('mcp_endpoint_input')" class="btn" style="background: #6366f1; color: white; border: none; border-radius: 8px; padding: 8px 14px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-copy"></i> কপি
                </button>
            </div>
        </div>

        <!-- API Key -->
        <div style="background: white; border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px 18px;">
            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">
                <i class="fas fa-key"></i> MCP API Key (Bearer Token)
            </label>
            <div style="display: flex; gap: 8px;">
                <input type="password" id="mcp_key_input" value="<?= htmlspecialchars($data['mcp_api_key']) ?>" readonly style="flex-grow: 1; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 8px; padding: 8px 12px; font-family: monospace; font-size: 0.9rem; color: #0f172a;">
                <button type="button" onclick="togglePasswordVisibility('mcp_key_input', this)" class="btn" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px; font-size: 0.85rem; cursor: pointer;">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" onclick="copyText('mcp_key_input')" class="btn" style="background: #4f46e5; color: white; border: none; border-radius: 8px; padding: 8px 14px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-copy"></i> কপি
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tabs: Configuration Guides -->
<div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
    <h3 style="margin: 0 0 16px; color: #0f172a; font-size: 1.25rem; font-weight: 800; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-book-open" style="color: #6366f1;"></i> AI এডিটর ও প্ল্যাটফর্মে কানেক্ট করার নির্দেশিকা
    </h3>

    <!-- Tab Buttons -->
    <div style="display: flex; gap: 10px; border-bottom: 2px solid #e2e8f0; margin-bottom: 20px; overflow-x: auto; padding-bottom: 2px;">
        <button type="button" onclick="switchGuideTab('tab-antigravity', this)" class="guide-tab-btn active" style="background: none; border: none; padding: 8px 18px; font-size: 0.95rem; font-weight: 700; color: #4f46e5; border-bottom: 3px solid #4f46e5; cursor: pointer;">
            <i class="fas fa-robot"></i> Antigravity (Google DeepMind)
        </button>
        <button type="button" onclick="switchGuideTab('tab-claude', this)" class="guide-tab-btn" style="background: none; border: none; padding: 8px 18px; font-size: 0.95rem; font-weight: 600; color: #64748b; cursor: pointer;">
            <i class="fas fa-brain"></i> Claude Desktop
        </button>
        <button type="button" onclick="switchGuideTab('tab-cursor', this)" class="guide-tab-btn" style="background: none; border: none; padding: 8px 18px; font-size: 0.95rem; font-weight: 600; color: #64748b; cursor: pointer;">
            <i class="fas fa-code"></i> Cursor / Windsurf
        </button>
        <button type="button" onclick="switchGuideTab('tab-curl', this)" class="guide-tab-btn" style="background: none; border: none; padding: 8px 18px; font-size: 0.95rem; font-weight: 600; color: #64748b; cursor: pointer;">
            <i class="fas fa-terminal"></i> Direct REST / cURL
        </button>
    </div>

    <!-- Tab 1: Antigravity -->
    <div id="tab-antigravity" class="guide-tab-content">
        <p style="color: #475569; font-size: 0.92rem; margin-bottom: 12px;">
            Antigravity-তে aaPanel এর মতো স্বয়ংক্রিয়ভাবে এই MCP সার্ভার যুক্ত করা হয়েছে। নিচের কনফিগারেশনটি আপনার <code>~/.gemini/config/mcp_config.json</code> ফাইলে যুক্ত করুন:
        </p>
        <div style="position: relative;">
            <pre id="code_antigravity" style="background: #0f172a; color: #e2e8f0; padding: 18px; border-radius: 12px; font-family: monospace; font-size: 0.88rem; overflow-x: auto; line-height: 1.5;">{
  "mcpServers": {
    "response": {
      "command": "python",
      "args": [
        "C:\\Users\\alannur\\.gemini\\config\\mcp-servers\\response\\server.py"
      ],
      "env": {
        "RESPONSE_API_URL": "<?= htmlspecialchars($data['api_endpoint']) ?>",
        "RESPONSE_API_KEY": "<?= htmlspecialchars($data['mcp_api_key']) ?>"
      }
    }
  }
}</pre>
            <button type="button" onclick="copyText('code_antigravity')" class="btn" style="position: absolute; top: 12px; right: 12px; background: #334155; color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-copy"></i> কপি কোড
            </button>
        </div>
    </div>

    <!-- Tab 2: Claude -->
    <div id="tab-claude" class="guide-tab-content" style="display: none;">
        <p style="color: #475569; font-size: 0.92rem; margin-bottom: 12px;">
            Claude Desktop-এর <code>claude_desktop_config.json</code> ফাইলে <code>mcpServers</code> ব্লকে নিচের অংশটি পেস্ট করুন:
        </p>
        <div style="position: relative;">
            <pre id="code_claude" style="background: #0f172a; color: #e2e8f0; padding: 18px; border-radius: 12px; font-family: monospace; font-size: 0.88rem; overflow-x: auto; line-height: 1.5;">{
  "mcpServers": {
    "response-website": {
      "command": "python",
      "args": ["path/to/response/server.py"],
      "env": {
        "RESPONSE_API_URL": "<?= htmlspecialchars($data['api_endpoint']) ?>",
        "RESPONSE_API_KEY": "<?= htmlspecialchars($data['mcp_api_key']) ?>"
      }
    }
  }
}</pre>
            <button type="button" onclick="copyText('code_claude')" class="btn" style="position: absolute; top: 12px; right: 12px; background: #334155; color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-copy"></i> কপি কোড
            </button>
        </div>
    </div>

    <!-- Tab 3: Cursor -->
    <div id="tab-cursor" class="guide-tab-content" style="display: none;">
        <p style="color: #475569; font-size: 0.92rem; margin-bottom: 12px;">
            Cursor Settings ➔ Features ➔ MCP Servers ➔ Add New MCP Server:
        </p>
        <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 12px; padding: 16px; font-size: 0.9rem;">
            <div><strong>Name:</strong> <code>response</code></div>
            <div style="margin-top: 6px;"><strong>Type:</strong> <code>command</code></div>
            <div style="margin-top: 6px;"><strong>Command:</strong> <code>python C:\Users\alannur\.gemini\config\mcp-servers\response\server.py</code></div>
        </div>
    </div>

    <!-- Tab 4: cURL -->
    <div id="tab-curl" class="guide-tab-content" style="display: none;">
        <p style="color: #475569; font-size: 0.92rem; margin-bottom: 12px;">
            সরাসরি HTTP POST রিকোয়েস্ট পাঠিয়ে যেকোনো প্রোগ্রামিং ল্যাঙ্গুয়েজ থেকে ব্যবহার করুন:
        </p>
        <div style="position: relative;">
            <pre id="code_curl" style="background: #0f172a; color: #e2e8f0; padding: 18px; border-radius: 12px; font-family: monospace; font-size: 0.88rem; overflow-x: auto; line-height: 1.5;">curl -X POST "<?= htmlspecialchars($data['api_endpoint']) ?>" \
  -H "Authorization: Bearer <?= htmlspecialchars($data['mcp_api_key']) ?>" \
  -H "Content-Type: application/json" \
  -d '{"action": "search_posts", "query": "তালাক", "limit": 5}'</pre>
            <button type="button" onclick="copyText('code_curl')" class="btn" style="position: absolute; top: 12px; right: 12px; background: #334155; color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-copy"></i> কপি কোড
            </button>
        </div>
    </div>
</div>

<!-- MCP Tools Catalog Table -->
<div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
    <h3 style="margin: 0 0 16px; color: #0f172a; font-size: 1.25rem; font-weight: 800; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-tools" style="color: #10b981;"></i> সক্রিয় MCP টুলস ও অ্যাকশনসমূহ
    </h3>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                    <th style="padding: 12px 16px; font-weight: 700; color: #475569;">টুল / ফাংশন</th>
                    <th style="padding: 12px 16px; font-weight: 700; color: #475569;">বিবরণ</th>
                    <th style="padding: 12px 16px; font-weight: 700; color: #475569;">প্যারামিটার</th>
                    <th style="padding: 12px 16px; font-weight: 700; color: #475569; text-align: center;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-weight: 700; color: #2563eb; font-family: monospace;">response_search_posts</td>
                    <td style="padding: 12px 16px; color: #334155;">টপিক বা কীওয়ার্ড অনুযায়ী সাইটের পোস্ট খুঁজে বের করে পূর্ণাঙ্গ লিংকসহ ফলাফল দেয়।</td>
                    <td style="padding: 12px 16px; color: #64748b; font-family: monospace; font-size: 0.85rem;">query (string), limit (int)</td>
                    <td style="padding: 12px 16px; text-align: center;"><button type="button" onclick="testTool('search_posts', {query: 'তালাক'})" class="btn btn-sm" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px 10px; font-size: 0.78rem;">পরীক্ষা করুন</button></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-weight: 700; color: #2563eb; font-family: monospace;">response_get_post</td>
                    <td style="padding: 12px 16px; color: #334155;">স্লাগ বা আইডি দিয়ে নির্দিষ্ট কোনো পোস্টের সম্পূর্ণ লেখা ও মেটাডাটা রিড করে।</td>
                    <td style="padding: 12px 16px; color: #64748b; font-family: monospace; font-size: 0.85rem;">slug_or_id (string)</td>
                    <td style="padding: 12px 16px; text-align: center;"><span style="color: #94a3b8; font-size: 0.8rem;">GET</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-weight: 700; color: #2563eb; font-family: monospace;">response_upload_docx_post</td>
                    <td style="padding: 12px 16px; color: #334155;">ওয়ার্ড ডকুমেন্ট (.docx) ফাইল সরাসরি আপলোড করে টাইটেল, স্লাগ, এসইও ও ক্যাটাগরি মিলিয়ে স্বয়ংক্রিয়ভাবে পোস্ট তৈরি করে।</td>
                    <td style="padding: 12px 16px; color: #64748b; font-family: monospace; font-size: 0.85rem;">docx_file_path / docx_base64</td>
                    <td style="padding: 12px 16px; text-align: center;"><span style="color: #10b981; font-weight: 700; font-size: 0.8rem;">Auto-Match</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-weight: 700; color: #2563eb; font-family: monospace;">response_publish_post</td>
                    <td style="padding: 12px 16px; color: #334155;">সরাসরি টাইটেল, পর্ব ও ক্যাটাগরি প্রদান করে পোস্ট পাবলিশ বা ড্রাফট করে।</td>
                    <td style="padding: 12px 16px; color: #64748b; font-family: monospace; font-size: 0.85rem;">title, slug, category, parts, status</td>
                    <td style="padding: 12px 16px; text-align: center;"><span style="color: #10b981; font-weight: 700; font-size: 0.8rem;">POST</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-weight: 700; color: #2563eb; font-family: monospace;">response_list_categories</td>
                    <td style="padding: 12px 16px; color: #334155;">সকল প্রধান ও সাব-ক্যাটাগরির ট্রি-ভিউ ও আইডি তালিকা প্রদর্শন করে।</td>
                    <td style="padding: 12px 16px; color: #64748b; font-family: monospace; font-size: 0.85rem;">none</td>
                    <td style="padding: 12px 16px; text-align: center;"><button type="button" onclick="testTool('list_categories', {})" class="btn btn-sm" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px 10px; font-size: 0.78rem;">পরীক্ষা করুন</button></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-weight: 700; color: #2563eb; font-family: monospace;">response_create_category</td>
                    <td style="padding: 12px 16px; color: #334155;">নতুন ক্যাটাগরি তৈরি করে এবং প্রয়োজন অনুযায়ী প্যারেন্ট ক্যাটাগরিতে লিংক করে।</td>
                    <td style="padding: 12px 16px; color: #64748b; font-family: monospace; font-size: 0.85rem;">name (string), parent_name (string)</td>
                    <td style="padding: 12px 16px; text-align: center;"><span style="color: #f59e0b; font-weight: 700; font-size: 0.8rem;">Auto-Heal</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-weight: 700; color: #2563eb; font-family: monospace;">response_list_questions</td>
                    <td style="padding: 12px 16px; color: #334155;">পাঠকদের প্রশ্ন তালিকা ও উত্তরহীন প্রশ্নের তালিকা বের করে।</td>
                    <td style="padding: 12px 16px; color: #64748b; font-family: monospace; font-size: 0.85rem;">status (all/unanswered), limit</td>
                    <td style="padding: 12px 16px; text-align: center;"><button type="button" onclick="testTool('list_questions', {status: 'all', limit: 5})" class="btn btn-sm" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px 10px; font-size: 0.78rem;">পরীক্ষা করুন</button></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-weight: 700; color: #2563eb; font-family: monospace;">response_get_site_stats</td>
                    <td style="padding: 12px 16px; color: #334155;">সাইটের সামগ্রিক পরিসংখ্যান (মোট পোস্ট, ভিজিটর ভিউ, প্রশ্ন ইত্যাদি) প্রদর্শন করে।</td>
                    <td style="padding: 12px 16px; color: #64748b; font-family: monospace; font-size: 0.85rem;">none</td>
                    <td style="padding: 12px 16px; text-align: center;"><button type="button" onclick="testTool('get_site_stats', {})" class="btn btn-sm" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px 10px; font-size: 0.78rem;">পরীক্ষা করুন</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Live Test Playground Console -->
<div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="margin: 0; color: #0f172a; font-size: 1.25rem; font-weight: 800; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-play-circle" style="color: #6366f1;"></i> লাইভ MCP API টেস্ট কনসোল (Live Playground)
        </h3>
        <button type="button" onclick="testPing()" class="btn btn-sm" style="background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe; border-radius: 8px; padding: 6px 14px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">
            <i class="fas fa-satellite-dish"></i> Ping সার্ভার টেস্ট
        </button>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #475569; margin-bottom: 6px;">
                অ্যাকশন সিলেক্ট করুন:
            </label>
            <select id="test_action_select" onchange="updateTestParamsPlaceholder()" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 0.9rem; margin-bottom: 12px;">
                <option value="search_posts">search_posts (পোস্ট খুঁজুন)</option>
                <option value="get_site_stats">get_site_stats (সাইট পরিসংখ্যান)</option>
                <option value="list_categories">list_categories (ক্যাটাগরি তালিকা)</option>
                <option value="list_questions">list_questions (পাঠকদের প্রশ্ন)</option>
                <option value="ping">ping (কানেকশন চেক)</option>
            </select>

            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #475569; margin-bottom: 6px;">
                JSON প্যারামিটার (Arguments):
            </label>
            <textarea id="test_params_input" style="width: 100%; height: 110px; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px; font-family: monospace; font-size: 0.88rem; box-sizing: border-box;">{
  "query": "তালাক",
  "limit": 3
}</textarea>
            
            <button type="button" onclick="executeSelectedTest()" id="btn_run_test" class="btn" style="background: #4f46e5; color: white; border: none; border-radius: 8px; padding: 10px 20px; font-weight: 700; font-size: 0.9rem; cursor: pointer; margin-top: 10px; width: 100%;">
                <i class="fas fa-play"></i> রিকোয়েস্ট পাঠান (Execute)
            </button>
        </div>

        <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #475569; margin-bottom: 6px;">
                সার্ভার রেসপন্স (JSON Output):
            </label>
            <pre id="test_output_box" style="background: #0f172a; color: #38bdf8; padding: 14px; border-radius: 8px; font-family: monospace; font-size: 0.82rem; height: 190px; overflow-y: auto; margin: 0; box-sizing: border-box;">// রেসপন্স দেখার জন্য বাম পাশের বাটনে ক্লিক করুন...</pre>
        </div>
    </div>
</div>

<script>
function copyText(elementId) {
    const el = document.getElementById(elementId);
    if (!el) return;
    const text = el.value || el.innerText || el.textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('ক্লিপবোর্ডে সফলভাবে কপি হয়েছে!');
    }).catch(err => {
        console.error('Copy failed:', err);
    });
}

function togglePasswordVisibility(inputId, btn) {
    const el = document.getElementById(inputId);
    if (!el) return;
    if (el.type === 'password') {
        el.type = 'text';
        btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
        el.type = 'password';
        btn.innerHTML = '<i class="fas fa-eye"></i>';
    }
}

function switchGuideTab(tabId, btn) {
    document.querySelectorAll('.guide-tab-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.guide-tab-btn').forEach(b => {
        b.style.color = '#64748b';
        b.style.borderBottom = 'none';
        b.style.fontWeight = '600';
    });
    const target = document.getElementById(tabId);
    if (target) target.style.display = 'block';
    if (btn) {
        btn.style.color = '#4f46e5';
        btn.style.borderBottom = '3px solid #4f46e5';
        btn.style.fontWeight = '700';
    }
}

function updateTestParamsPlaceholder() {
    const action = document.getElementById('test_action_select').value;
    const input = document.getElementById('test_params_input');
    if (action === 'search_posts') {
        input.value = JSON.stringify({ query: 'তালাক', limit: 3 }, null, 2);
    } else if (action === 'list_questions') {
        input.value = JSON.stringify({ status: 'all', limit: 5 }, null, 2);
    } else {
        input.value = '{}';
    }
}

function testPing() {
    testTool('ping', {});
}

function executeSelectedTest() {
    const action = document.getElementById('test_action_select').value;
    let params = {};
    try {
        params = JSON.parse(document.getElementById('test_params_input').value);
    } catch(e) {
        alert('অবৈধ JSON সিনট্যাক্স! অনুগ্রহ করে সঠিক JSON ফরম্যাট প্রদান করুন।');
        return;
    }
    testTool(action, params);
}

function testTool(action, params) {
    const outBox = document.getElementById('test_output_box');
    outBox.textContent = '// রিকোয়েস্ট প্রসেস হচ্ছে...';
    outBox.style.color = '#f59e0b';

    const apiKey = document.getElementById('mcp_key_input').value;
    const endpoint = document.getElementById('mcp_endpoint_input').value;

    const payload = Object.assign({ action: action }, params);

    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + apiKey
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        outBox.textContent = JSON.stringify(data, null, 2);
        outBox.style.color = data.status === 'success' || data.success ? '#4ade80' : '#f87171';
    })
    .catch(err => {
        outBox.textContent = 'ত্রুটি: ' + err.toString();
        outBox.style.color = '#ef4444';
    });
}
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>
